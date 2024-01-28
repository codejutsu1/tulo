<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Transaction;
use App\Traits\HttpResponses;

class TransactionService {
    use HttpResponses;
    
    public function storeTransaction($response, $payment)
    {
        $service = $payment['metadata']['service'];
        $amount = $payment['amount'];
        $original_price = $this->originalPrice($response, $service);
        $profit = $this->profit($amount, $original_price);
        $data_plan = $this->data_plan($service);
        $package_id = $this->package_id($response);

        if($response['code'] == 'success'){
            $transaction = Transaction::create([
                'user_id' => 1,
                'package_id' => $package_id ?? null,
                'reference' => $payment['reference'],
                'status' => $response['code'],
                'message' => $response['message'],
                'network' => $response['data']['network'],
                'phone' => $response['data']['phone'],
                'original_price' => $original_price,
                'profit' => $profit,
                'amount' => $amount, // amount charged or selling price.
                'data_plan' => $data_plan,
                'order_id' => $response['data']['order_id'],
                'cable_tv' => $response['data']['cable_tv'],
                'subscription_plan' => $response['data']['subscription_plan'],
                'smartcard_number' =>  $response['data']['smartcard_number'],
            ]);

            return $this->success($transaction);
        }
    }

    private function originalPrice($response, $service)
    {
        if($service === 'airtime'){
            $airtimeService = new AirtimeService();

            $price = (integer) str_replace('NGN', '', $response['data']['amount']);

            $original_price = $airtimeService->originalPrice($price, $response['data']['network']);
            
            return $original_price;
        }

        if($service === 'tv') return $response['data']['amount_charged'];

        if($service === 'data') return $response['data']['amount'];
    }

    private function profit($amount, $original_price)
    {
        return $amount - $original_price;
    }

    private function data_plan($service)
    {
        if($service === 'airtime') return 'airtime'

        return null;
    }

    private function package_id($response)
    {
        $data_plan = $response['data']['data_plan'] ?? null;
        $subscription_plan = $response['data']['subscription_plan'] ?? null;
        
        $id = Package::where('plan', $data_plan)->orWhere('plan', $subscription_plan)->value('id');

        return $id;
    }
}