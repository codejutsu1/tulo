<?php

namespace App\Http\Controllers\Payment;

use Paystack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    /**
     * Obtain Paystack payment information
     * @return void
     */

    public function handleGatewayCallback()
    {
        dd(paystack()->getAllTransactions());
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
