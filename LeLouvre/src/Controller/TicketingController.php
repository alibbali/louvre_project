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
        //$payment->paid($totalPrix);



        return $this->render('reservation/summary.html.twig', [
            'reservation' => $reservation,
            'totalPrix' => $totalPrix
        ]);
    }
}