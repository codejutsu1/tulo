<?php

namespace App\Services;

use Paystack;
use App\Traits\Vtu;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Redirect;

class PaymentService {
    use HttpResponses, Vtu;
    public function redirectToGateway($data)
    {
        try{
            return Paystack::getAuthorizationUrl($data);
        }catch(\Exception $e) {
            return $this->error(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error'], 422);
        }        
    }


    public function storePayment($payment)
    {
        $paymentService = $payment['metadata']['service'];
        $phone = $payment['metadata']['phone'];
        $network_id = $payment['metadata']['network'];
        $variation_id = $payment['metadata']['variation_id'];
        $amount = $payment['amount'];

        $response = Http::get("https://vtu.ng/wp-json/api/v1/$paymentService", [
            'username' => $this->username(),
            'password' => $this->password(),
            'phone' => $phone,
            'network_id' => $network_id ?? null,
            'variation_id' => $variation_id ?? null,
            'amount' => $amount ?? null,
            'service_id' => $service_id ?? null,
            'smartcard_number' => $smartcard_number ?? null,
        ]);

        $response = $response->json(); 

        $errors = ['empty_username', 'empty_password', 'invalid_username', 'Incorrect_password'];

        foreach($errors as $error){
            if($response['code'] === $error) {
                Mail::to('codejutsu@protonmail.com')->send(new VtuError($response['message']));

                return $this->message('Something went wrong, contact the Admin.', 500);
            }        
        }

        if($response['code'] === 'failure') {
            if(str_contains($response['message'], 'wallet balance') && str_contains($response['message'], 'insufficient')) {
                Mail::to('codejutsu@protonmail.com')->send(new VtuError($response['message']));

                return $this->message('Something went wrong, contact the Admin.', 500);
            } 
        }

        if($response['code'] != 'success') return $this->error($response['message'], 422);

        if($paymentService === 'airtime')
        {
            $airtimeService = new AirtimeService();

            $price = (integer) str_replace('NGN', '', $response['data']['amount']);

            $original_price = $airtimeService->originalPrice($price, $response['data']['network']);
    
            $profit = $airtimeService->profit($original_price, $price);
        }

        if($response['code'] == 'success'){
            $transaction = Transaction::create([
                'user_id' => 1,
                'status' => $response['code'],
                'message' => $response['message'],
                'network' => $response['data']['network'],
                'phone' => $response['data']['phone'],
                'original_price' => $original_price,
                'profit' => $profit,
                'amount' => $price,
                'data_plan' => $paymentService ?? 'airtime' : null,
                'order_id' => $response['data']['order_id']
            ]);

            return $transaction;
        }
    }
}