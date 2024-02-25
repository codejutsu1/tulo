<?php

namespace App\Services;

use App\Traits\Vtu;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Services\PhoneService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class AirtimeService {
    use Vtu, HttpResponses;

    public function __construct(
        private PhoneService $phoneService,
        private PaymentService $paymentService
        ){}
    
    public function buyAirtime($request): JsonResponse
    {
        $phone = $this->phoneService->formatNumber($request['phoneNumber']);
        $network_id = $this->phoneService->networkProvider($phone);


        $data = [
            'amount' => $request['amount'] * 100,
            'reference' => paystack()->genTranxRef(),
            'email' => 'danieldunu001@gmail.com', //Authenticated User
            'currency' => 'NGN',
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'service' => 'airtime',
                'phone' => $phone,
                'network' =>  $network_id,
            ],
        ];

        $paymentResponse = $this->paymentService->redirectToGateway($data);

        return $this->success(['paymentUrl' => $paymentResponse->url]);
    }

    public function originalPrice($price, $network=null): int
    {
        $discount = 0.03;

        if($network === 'MTN') $discount = 0.025;

        $discount_price = $price * $discount;

        $original_price = $price - $discount_price;

        return (integer) $original_price;
    }
}