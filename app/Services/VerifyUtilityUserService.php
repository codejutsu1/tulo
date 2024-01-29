<?php

namespace App\Services;

use App\Traits\Vtu;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class VerifyUtilityUserService {
    use Vtu;

    public function verifyUser($request): JsonResponse
    {
        $response = Http::get('https://vtu.ng/wp-json/api/v1/verify-customer', [
            'username' => $this->username(),
            'password' => $this->password(),
            'customer_id' => $request['smartcard_number'],
            'service_id' => $request['service_id'],
            'variation_id' => $request['variation_id'] ?? ''
        ]);

        return $response->json();    
    }
}