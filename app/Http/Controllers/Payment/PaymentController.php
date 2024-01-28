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

    public function __construct(private PaymentService $paymentService){}

    public function handleGatewayCallback()
    {
        // dd(paystack()->getAllTransactions());

        $paymentDetails = Paystack::getPaymentData();

        if($paymentDetails['status'] != 'success'){
            return $this->error([
                'message' => $paymentDetails['message'],
                'status' => $paymentDetails['status'],
                'gateway_response' => $paymentDetails['gateway_response'],
            ]);
        }

        $paymentDetails = [
            'id' => 474747,
            'status' => 'success',
            'reference' => 'fasadv',
            'amount' => 7000,
            'metadata' => [

            ]
        ];

        $paymentService->storePayment($paymentDetails);
    }
}
