<?php

namespace App\Services;

class Payment {

    public function paid($value, $stripeToken) {

        \Stripe\Stripe::setApiKey("sk_test_xB9p9DMEguzDzlc7MGIA2Wpr");

      $response = \Stripe\Charge::create([
          "amount" => $value * 100,
          "currency" => "eur",
          "source" => $stripeToken, // obtained with Stripe.js
          "description" => "Charge for jenny.rosen@example.com"
        ]);
            
        return $response;
    }
}