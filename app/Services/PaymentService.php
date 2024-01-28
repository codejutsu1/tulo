<?php

namespace App\Services;

use Paystack;
use App\Services\VtuService;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Redirect;

class PaymentService {
    public function redirectToGateway($data)
    {
        try{
            return Paystack::getAuthorizationUrl($data);
        }catch(\Exception $e) {
            return $this->error(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error'], 422);
        }        
    }


    public function storePayment($payment)
    {
        $vtuService = new VtuService();
        $errorService = new ErrorService();
        $transactionService = new TransactionService();

        $response = $vtuService->purchaseVtu($payment); 
        
        if($response['code'] != 'success') return $errorService->returnErrorMessages($response);

        return $transactionService->storeTransaction($response, $payment);
    }
}