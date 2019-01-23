<?php

namespace App\Services;

use App\Entity\Reservation;

class GivePrice {

    public function givePrice(Reservation $reservation) {
            //today est en dehors de la boucle pour éviter que la meme valeur soit ajouter à la boucle
            $today = new \Datetime();

            foreach($reservation->getBillets() as $billet) {
                $naissance = $billet->getNaissance();
                $age = $today->diff($naissance);
                $age = $age->format('%y');

                if($age > 60) {
                    $billet->setPrix(12);
                }
                elseif($age > 12 && $age < 60) {
                    $billet->setPrix(16);
                }
                elseif($age > 4 && $age < 12) {
                    $billet->setPrix(8);
                }
                else {
                    $billet->setPrix(0);
                }
            }
        } 

    public function totalPrice(Reservation $reservation) {

        
        $total = 0;
        foreach($reservation->getBillets() as $billet) {
            $total += $billet->getPrix();
        }

        return $total;
    }
}