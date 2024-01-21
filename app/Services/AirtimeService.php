<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\PhoneService;
use Illuminate\Support\Facades\Http;

class AirtimeService {
    public function buyAirtime(Request $request)
    {
        $phoneService = new PhoneService();
        $username = config('vtu.vtu_username');
        $password = config('vtu.vtu_password');
        $phone = $phoneService->formatNumber($request->phoneNumber);
        $network_id = $phoneService->networkProvider($phone);

        $response = Http::get('https://vtu.ng/wp-json/api/v1/airtime', [
            'username' => $username,
            'password' => $password,
            'phone' => $phone,
            'network_id' => $network_id,
            'amount' => $request->amount,
        ]); 

        return $response->json();
    }
}