<?php

namespace App\Services;

class Payment {

    public function paid($value) {

        \Stripe\Stripe::setApiKey("sk_test_xB9p9DMEguzDzlc7MGIA2Wpr");

        \Stripe\Charge::create([
          "amount" => 2000,
          "currency" => "eur",
          "source" => "tok_amex", // obtained with Stripe.js
          "description" => "Charge for jenny.rosen@example.com"
        ]);
    
    }
}