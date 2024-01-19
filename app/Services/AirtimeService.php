<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AirtimeService {

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public static function buyAirtime(Request $request)
    {
        $username = config('vtu.vtu_username');
        $password = config('vtu.vtu_password');
        $phone = $this->phoneService->formatNumber($request->number);
        $network_id = $this->phoneService->networkProvider($request->number);

        $response = Http::get('https://vtu.ng/wp-json/api/v1/airtime', [
            'username' => $username,
            'password' => $password
            'phone' => $phone,
            'network_id' => $network_id,
            'amount' => $request->amount,
        ]); 
    }
}