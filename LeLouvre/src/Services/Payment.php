<?php

namespace App\Services;

class Payment {

    public function paid($value) {

        \Stripe\Stripe::setApiKey('sk_test_xB9p9DMEguzDzlc7MGIA2Wpr');
        $charge = \Stripe\Charge::create([
            'amount' => $value,
            'currency' => 'eur',
            'source' => 'tok_visa'
            ]);

        echo $charge;
    }
}