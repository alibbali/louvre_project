<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use App\Repository\ReservationRepository;

class NotAllowedDateValidator extends ConstraintValidator
{

    /**
     * @var ReservationRepository
     */
    private $em;

    public function __construct(ReservationRepository $em) {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
       

        //Je transforme l'objet en array pour récuperer uniquement la date
        $value = get_object_vars($value);
        $date = $value['date'];
        $today = date('d/m/y');

        
        //Je formate de façon à récuperer les éléments voulus
        $formatedDate = date('m/d', strtotime($date));
        $daysOfFormattedDate = date('N', strtotime($date));
        $formatedTime = date('H:i', strtotime($date));
        
        /* echo '<pre>';
        var_dump($date, $today, $formatedDate, $daysOfFormattedDate, $formatedTime);
        die;
        echo '</pre>'; */
        //ici sera la liste complête des jours fériés que je dois mettre au format anglais sinon cela ne fonctionne pas....
        $notAllowedDate = ["05/01", "12/25", "11/01"];
        
        //Je scinde pour éviter de boucler et pour améliorer la performance
        //D'abord si formatedDate est égal à une des valeur du tableau NotAllowedDate
        if (in_array($formatedDate, $notAllowedDate)) {
            $message = $this->context->buildViolation("Le musée est fermé les jours fériés.")
                                  ->atPath('dateVisite')
                                  ->addViolation();
                    return $message;
        }
        //Si c'est un mardi
        elseif($daysOfFormattedDate == 2 ){
            $message = $this->context->buildViolation("Le musée est fermé le mardi, impossible de commander.")
                           ->atPath('dateVisite')
                           ->addViolation();
             return $message;
         }
        /*     foreach ($notAllowedDate as $key) {
                $formatedList = date('d/m', strtotime($key));
                //Si la date choisi est un jour férié :
                if($formatedDate == $formatedList) {
                   
                    $message = $this->context->buildViolation("Le musée est fermé les jours fériés.")
                                  ->atPath('dateVisite')
                                  ->addViolation();
                    return $message;
                }
                //Si c'est un mardi
                elseif($daysOfFormattedDate == 2 ){
                   $message = $this->context->buildViolation("Le musée est fermé le mardi, impossible de commander.")
                                  ->atPath('dateVisite')
                                  ->addViolation();
                    return $message;
                }
            } */
    }
}
