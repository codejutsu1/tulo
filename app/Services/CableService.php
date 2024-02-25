<?php

namespace App\Services;

use App\Models\Package;
use App\Traits\HttpResponses;
use App\Services\PhoneService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CableService {
    use HttpResponses;
    
    public function buyCable($request): JsonResponse
    {
        $phoneService = new PhoneService();
        $paymentService = new PaymentService();

        $phoneNumber = $phoneService->formatNumber($request['phoneNumber']);

        $amount = Package::where('variation_id', $request['variation_id'])->value('price');

        $data = [
            'amount' => 1000000, //amount shouldn't be null
            'reference' => paystack()->genTranxRef(),
            'email' => 'danieldunu001@gmail.com', //Authenticated User
            'currency' => 'NGN',
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'service' => 'tv',
                'phone' => $phoneNumber,
                'service_id' =>  $request['service_id'],
                'smartcard_number' => $request['smartcard_number'],
                'variation_id' => $request['variation_id'],
            ],
        ];

        $paymentResponse = $paymentService->redirectToGateway($data);

        return $this->success(['paymentUrl' => $paymentResponse->url]);
    }
}