<?php

namespace App\Services;

use App\Traits\Vtu;
use Illuminate\Support\Facades\Http;

class VtuService{
    use Vtu;
    public function purchaseVtu($payment)
    {
        $paymentService = $payment['metadata']['service'];
        $phone = $payment['metadata']['phone'];
        $network_id = $payment['metadata']['network'] ?? null;
        $variation_id = $payment['metadata']['variation_id'] ?? null;
        $amount = $payment['amount'] ?? null;
        $smartcard_number = $payment['metadata']['smartcard_number'] ?? null;
        $service_id = $payment = $payment['metadata']['service_id'] ?? null;    

        $response = Http::get("https://vtu.ng/wp-json/api/v1/$paymentService", [
            'username' => $this->username(),
            'password' => $this->password(),
            'phone' => $phone,
            'network_id' => $network_id ?? null,
            'amount' => $amount ?? null,
            'service_id' => $service_id ?? null,
            'smartcard_number' => $smartcard_number ?? null,
            'variation_id' => $variation_id ?? null,
        ]);

        return $response->json();
    }
}