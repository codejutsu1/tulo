<?php

namespace App\Services;

use Paystack;
use Illuminate\Support\Facades\Redirect;

class PaymentService {

    public function redirectToGateway()
    {
        $data = [
            'amount' => 1000 * 100,
            'reference' => paystack()->genTranxRef(),
            'email' => 'danieldunu001@gmail.com',
            'currency' => 'NGN',
            'callback_url' => route('payment.callback'),
        ];

        try{
            return Paystack::getAuthorizationUrl($data);
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }
}