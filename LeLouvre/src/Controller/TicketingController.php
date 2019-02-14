<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\BilletsRepository;
use App\Repository\ReservationRepository;
use App\Form\BilletsType;
use App\Form\ReservationType;
use App\Entity\Billets;
use App\Entity\Reservation;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Services\GivePrice;
use App\Services\Payment;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class TicketingController extends AbstractController {

    /**
     * @var BilletsRepository
     */
    private $billetsRepository;

    /**
     * @var ReservationRepository
     */
    private $reservationRepository;
    
    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(BilletsRepository $billetsRepository,ReservationRepository $reservationRepository,ObjectManager $em) {
        $this->billetsRepository = $billetsRepository;
        $this->reservationRepository = $reservationRepository;
        $this->em = $em;
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function new(Request $request,SessionInterface $session,GivePrice $givePrice) {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $session->set('Reservation', $reservation);
            //Redirection vers la fin du paiement avec email + Stripe
            return $this->redirectToRoute('summary');
        }
    
    return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/summary", name="summary")
     */
    public function summary(SessionInterface $session, GivePrice $givePrice,Payment $payment) {

        $reservation = $session->get('Reservation');

        $givePrice->givePrice($reservation);
        $totalPrix = $givePrice->totalPrice($reservation);

        return $this->render('reservation/summary.html.twig', [
            'reservation' => $reservation,
            'totalPrix' => $totalPrix
        ]);
    }

    /**
     * @Route("/charge", name="charge")
     */
    public function charge(SessionInterface $session, GivePrice $givePrice, Payment $payment, \Swift_Mailer $mailer, ObjectManager $em){
        $reservation = $session->get('Reservation');
        $stripeToken = $_POST['stripeToken'];
        //mail
        $email = $_POST['email'];
        //prixTotal
        $totalPrix = $givePrice->totalPrice($reservation);
        $transaction = $payment->paid($totalPrix, $stripeToken);
        if($transaction->status == "succeeded") {
            //Je set l'entité avec le mail
            $reservation->setEmail($email);
            //Je persiste
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            //Mail
            $message = (new \Swift_Message('Test email'))
                       ->setFrom('brian.alibali@gmail.com')
                       ->setTo($reservation->getEmail())
                       ->setBody($this->renderView(
                           'emails/registration.html.twig',
                           ['reservation' => $reservation]
                       ),
                       'text/html'
                    );
                                    
            $mailer->send($message);
            $entityManager->flush();
            //Redirection page de confirmation de paiement
            $session->invalidate();
            $flash = $this->addFlash('notice', 'Regardez dans votre boite mail, vos billets seront bientôt là ! :)');
            return $this->redirectToRoute('home', [
                'notice' => $flash
            ]);
            //Détruire la session à la fin
        } else {
            $flash = $this->addFlash('notice', 'Il y a eu une erreur lors du paiement, merci de réessayer');
            return $this->redirectToRoute('reservation', [
                'notice' => $flash
            ]);
        }

    }
}