<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use App\Repository\ReservationRepository;
//use Symfony\Component\HttpFoundation\Session\Session;

class CheckBilletsValidator extends ConstraintValidator
{

    /**
     * @var ReservationRepository
     */
    private $em;

    public function __construct(ReservationRepository $entityManager) {
        $this->em = $entityManager;
    }


    public function validate($visiteDate, Constraint $constraint)
    {
        if ($this->em->getTotalReservations($visiteDate) >= 1000) {
            $this->context->buildViolation($constraint->message)->atPath('type')->addViolation();
        }
    }
}
