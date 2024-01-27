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
        $paymentService = $data['metadata']['service'];
        $phone = $data['metadata']['phone'];
        $network_id = $data['metadata']['network'];
        $variation_id = $data['metadata']['variation_id'];
        $amount = $data['metadata']['amount'];

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

        if($response['code'] == 'success'){
            $transaction = Transaction::create([
                'user_id' => 1,
                'status' => $test['code'],
                'message' => $test['message'],
                'network' => $test['data']['network'],
                'phone' => $test['data']['phone'],
                'original_price' => $original_price,
                'profit' => $profit,
                'amount' => $price,
                'data_plan' => 'airtime',
                'order_id' => $test['data']['order_id']
            ]);

            return $transaction;
        }
    }
}