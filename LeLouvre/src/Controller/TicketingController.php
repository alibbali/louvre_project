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
    public function new(Request $request) {

        $billets = new Billets();
        $billetsForm = $this->createForm(BilletsType::class, $billets);
        
/*         $reservation = new Reservation();
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
 */       

    return $this->render('reservation/reservation.html.twig', [
            'billets' => $billetsForm->createView()
        ]);
  }
}