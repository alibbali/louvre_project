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
        //$this->context->getObject();
        //Récuperer la date de visite
        $request = $this->requestStack->getCurrentRequest();
        $form = $request->request->get('reservation');
        $arrayDate = $form['dateVisite'];

        //Récupération d'une variable de la date d'aurjourd'hui et de l'heure actuelle
        $today = date('d/m/y');
        $hour = date('G:i');
        
        //Je récupére la date inscrite sur le formulaire et je la convertie en date pour eviter les erreurs
        $stringDate = implode("-", $arrayDate);
        $date = date('d/m/y', strtotime($stringDate));

        //Condition de vérification value false = demi journée
        if($value == false && $date == $today && $hour > "14:00" ) {
            
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}
