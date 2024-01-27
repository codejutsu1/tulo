<?php

namespace App\Services;

use App\Traits\Vtu;
use Illuminate\Http\Request;
use App\Services\PhoneService;
use Illuminate\Support\Facades\Http;

class AirtimeService {
    use Vtu;
    
    public function buyAirtime(Request $request)
    {
        $phoneService = new PhoneService();
        $phone = $phoneService->formatNumber($request->phoneNumber);
        $network_id = $phoneService->networkProvider($phone);

        $response = Http::get('https://vtu.ng/wp-json/api/v1/airtime', [
            'username' => $this->username(),
            'password' => $this->password(),
            'phone' => $phone,
            'network_id' => $network_id,
            'amount' => $request->amount,
        ]); 

        return $response->json();
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