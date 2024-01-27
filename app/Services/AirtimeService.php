<?php

namespace App\Services;

use App\Traits\Vtu;
use Illuminate\Http\Request;
use App\Services\PhoneService;
use Illuminate\Support\Facades\Http;

class AirtimeService {
    use Vtu;
    
    public function buyAirtime($request)
    {
        $phoneService = new PhoneService();
        $phone = $phoneService->formatNumber($request['phoneNumber']);
        $network_id = $phoneService->networkProvider($phone);


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

        $paymentService = new PaymentService();

        $paymentResponse = $paymentService->redirectToGateway($data);

        return $this->success(['paymentUrl' => $paymentResponse->url]);
    }

    public function originalPrice($price, $network=null)
    {
        $discount = 0.03;

        if($network === 'MTN') $discount = 0.025;

        $discount_price = $price * $discount;

        $original_price = $price - $discount_price;

        return $original_price;
    }

    public function profit($original_price, $price)
    {
        return $price - $original_price;
    }
}