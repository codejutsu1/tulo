<?php 

namespace App\Services;

use App\Traits\Vtu;
use App\Models\Data;
use App\Models\Network;
use App\Services\PhoneService;
use Illuminate\Support\Facades\Http;


class DataService {
    use Vtu;

    public function buyData($request)
    {
        $phoneService = new PhoneService();
        $phoneNumber = $request['phoneNumber'];
        $variation_id = $request['variation_id'];

        $phoneNumber = $phoneService->formatNumber($phoneNumber);
        $network_provider = $phoneService->networkProvider($phoneNumber);

        $network = Network::with('data')->where('network', $network_provider)->first();

        $variations = $network->data->pluck('variation_id')->toArray();

        if(!in_array($variation_id, $variations)){
            return "The number doesn't match the network provider of this service";
        }

        $amount = Packages::where('variation_id', $variation_id)->value('amount');

        $response = Http::get('https://vtu.ng/wp-json/api/v1/data', [
            'username' => $this->username(),
            'password' => $this->password(),
            'phone' => $phoneNumber,
            'network_id' => $network_provider,
            'variation_id' => $variation_id 
        ]);

        return $response->json();
    }
}