<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Transaction;
use App\Traits\HttpResponses;
use App\Services\AirtimeService;
use Illuminate\Http\JsonResponse;

class TransactionService {
    use HttpResponses;

    public function __construct(private AirtimeService $airtimeService){}
    
    public function storeTransaction($response, $payment): JsonResponse
    {
        $service = $payment['metadata']['service'];
        $amount = $payment['amount'];
        $original_price = $this->originalPrice($response, $service, $payment);
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
                'network' => $response['data']['network'] ?? null,
                'phone' => $response['data']['phone'],
                'original_price' => $original_price,
                'profit' => $profit,
                'amount' => $amount, // amount charged or selling price.
                'data_plan' => $data_plan,
                'order_id' => $response['data']['order_id'] ?? null,
                'cable_tv' => $response['data']['cable_tv'] ?? null,
                'subscription_plan' => $response['data']['subscription_plan'] ?? null,
                'smartcard_number' =>  $response['data']['smartcard_number'] ?? null,
            ]);

            return $this->success($transaction);
        }
    }

    private function originalPrice($response, $service, $payment): int
    {
        if($service === 'airtime'){
            $price = $this->getAmountInteger($response['data']['amount']);

            $original_price = (integer) $this->airtimeService->originalPrice($price, $payment['metadata']['network']);
            
            return $original_price;
        }

        if($service === 'tv') return $this->getAmountInteger($response['data']['amount_charged']);

        if($service === 'data') return $this->getAmountInteger($response['data']['amount']);
    }

    private function getAmountInteger($amount):int
    {
        return (integer) str_replace('NGN', '', $amount);
    }

    private function profit($amount, $original_price): int
    {
        return $amount - $original_price;
    }

    private function data_plan($service): ?string
    {
        if($service === 'airtime') return 'airtime';
    }

    private function package_id($response): ?int
    {
        $data_plan = $response['data']['data_plan'] ?? null;
        $subscription_plan = $response['data']['subscription_plan'] ?? null;
        
        $id = Package::where('plan', $data_plan)->orWhere('plan', $subscription_plan)->value('id');

        return $id;
    }
}