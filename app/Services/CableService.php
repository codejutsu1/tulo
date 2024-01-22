<?php

namespace App\Services;

use App\Traits\Vtu;
use App\Services\PhoneService;
use Illuminate\Support\Facades\Http;

class CableService {
    use Vtu;
    
    public function buyCable($request) 
    {
        $phoneNumber = (new PhoneService)->formatNumber($request['phoneNumber']);

        $response = Http::get('https://vtu.ng/wp-json/api/v1/tv', [
            'username' => $this->username(),
            'password' => $this->password(),
            'phone' => $phoneNumber,
            'service_id' => $request['service_id'],
            'smartcard_number' => $request['smartcard_number'],
            'variation_id' => $request['variation_id']
        ]);

        return $response;
    }
}