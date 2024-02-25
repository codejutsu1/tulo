<?php

namespace App\Services;

use Paystack;
use App\Services\VtuService;
use App\Traits\HttpResponses;
use App\Services\ErrorService;
use Illuminate\Http\JsonResponse;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Redirect;

class PaymentService {
    use HttpResponses;

    public function redirectToGateway($data)
    {
        try{
            return Paystack::getAuthorizationUrl($data);
        }catch(\Exception $e) {
            dd($e);
            return $this->error(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error'], 422);
        }        
    }


    public function storePayment($payment): JsonResponse
    {
        $vtuService = new VtuService();
        $errorService = new ErrorService();
        $transactionService = new TransactionService();

        $response = $this->vtuService->purchaseVtu($payment); 
        
        if($response['code'] != 'success') return $this->errorService->returnErrorMessages($response);

        return $this->transactionService->storeTransaction($response, $payment);
    }
}