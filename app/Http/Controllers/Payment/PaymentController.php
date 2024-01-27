<?php

namespace App\Http\Controllers\Payment;

use Paystack;
use Illuminate\Http\Request;
use App\Services\PaymentService;
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

        if($paymentDetails['status'] == 'success'){
            $paymentService = new PaymentService();

            $paymentService->storePayment($paymentDetails);
        }else {
            return $this->error([
                'message' => $paymentDetails['message'],
                'status' => $paymentDetails['status'],
                'gateway_response' => $paymentDetails['gateway_response'],
            ]);
        }
    }
}
