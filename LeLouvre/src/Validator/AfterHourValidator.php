<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\HttpFoundation\RequestStack;

class AfterHourValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }
    public function validate($value, Constraint $constraint)
    {
        $request = $this->requestStack->getCurrentRequest();
        $form = $request->request->get('reservation');
        $arrayDate = $form['dateVisite'];
        
        //Récupération d'une variable de la date d'aurjourd'hui et de l'heure actuelle
        date_default_timezone_set('Europe/Paris');
        $today = date('d/m/y');
        $hour = date('H:i');
        //Je récupére la date inscrite sur le formulaire et je la convertie en date pour eviter les erreurs
        $stringDate = implode("-", $arrayDate);
        $date = date('d/m/y', strtotime($stringDate));
        $limitDate = "14:00";
        
        if($value == true && $date == $today && $hour > $limitDate ) {
            
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}
