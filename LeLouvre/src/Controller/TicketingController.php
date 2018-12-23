<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BilletsRepository;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Billets;
use App\Form\BilletsType;
use App\Entity\Reservation;
use App\Form\ReservationType;


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
        $reservation = new Reservation();
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        
        
/*         $billetsForm->handleRequest($request);
    
        if ($billetsForm->isSubmitted() && $billetsForm->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Votre annonce a bien été créée.');
            return $this->redirectToRoute('admin.property.index');
        }
 */

        return $this->render('pages/reservation.html.twig', [
            'billets' => $billets,
            'billetsForm' => $billetsForm->createView(),
            'reservationForm' => $reservationForm->createView()
        ]);
    }
}