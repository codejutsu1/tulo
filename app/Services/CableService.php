<?php

namespace App\Services;

use App\Traits\Vtu;
use App\Services\PhoneService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class CableService {
    use Vtu;
    
    public function __construct(
        private PhoneService $phoneService,
        private PaymentService $paymentService,
    ){}
    
    public function buyCable($request): JsonResponse
    {
        $phoneNumber = $this->phoneService->formatNumber($request['phoneNumber']);

        $amount = Package::where('variation_id', $request['variation_id'])->value('price');

        $data = [
            'amount' => $amount * 100,
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

        $paymentResponse = $this->paymentService->redirectToGateway($data);

        return $this->success(['paymentUrl' => $paymentResponse->url]);
    }
}