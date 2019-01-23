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
    public function new(Request $request,Session $session,GivePrice $givePrice) {

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $testService = $givePrice->givePrice($reservation);
            //$session = $session->start();
            //$session->set('Reservation', $reservation);
            //$this->em->persist($reservation);
            //$this->em->flush();
            echo '<pre>';
            var_dump($reservation, $testService);
            die;
            echo '</pre>';
            //$this->addFlash('success', 'Votre billet a bien été enregistré.');
            //Redirection vers la fin du paiement avec email + Stripe
            return $this->redirectToRoute('reservation');
        }
    
    return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }

}