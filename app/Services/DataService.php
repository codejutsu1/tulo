<?php 

namespace App\Services;

use App\Traits\Vtu;
use App\Models\Package;
use App\Models\Utility;
use App\Traits\HttpResponses;
use App\Services\PhoneService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Http;


class DataService {
    use Vtu, HttpResponses;

    public function buyData($request)
    {
        $phoneNumber = $request['phoneNumber'];

        $variation_id = $request['variation_id'];

        $phoneService = new PhoneService();

        $phoneNumber = $phoneService->formatNumber($phoneNumber);

        $network_provider = $phoneService->networkProvider($phoneNumber);

        $network = Utility::with('packages')->where('name',$network_provider)->first();

        $variations = $network->packages->pluck('variation_id')->toArray();

        if(!in_array($variation_id, $variations)){
            return $this->error("The number doesn't match the network provider of this service", 404);
        }

        $amount = Package::where('variation_id', $variation_id)->value('price');

        $data = [
            'amount' => $amount * 100,
            'reference' => paystack()->genTranxRef(),
            'email' => 'danieldunu001@gmail.com', //Authenticated User
            'currency' => 'NGN',
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'service' => 'data',
                'phone' => $phoneNumber,
                'network' =>  $network_provider,
                'variation_id' => $variation_id,
            ],
        ];

        $paymentService = new PaymentService();

        $paymentResponse = $paymentService->redirectToGateway($data);

        return $this->success(['paymentUrl' => $paymentResponse->url]);
    }
}