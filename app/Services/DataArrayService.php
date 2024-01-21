<?php

namespace App\Services;

class DataArrayService {

    public function getMtnData() {
        return [ 
            [
                'network_id' => 1,
                'variation_id' => '500',
                'plan' => 'MTN Data 500MB - 30 Days',
                'price' => 350
            ],

            [
                'network_id' => 1,
                'variation_id' => 'M1024',
                'plan' => 'MTN Data 1GB - 30 Days',
                'price' => 450
            ],

            [
                'network_id' => 1,
                'variation_id' => 'M2024',
                'plan' => 'MTN Data 2GB - 30 Days',
                'price' => 750
            ],

            [
                'network_id' => 1,
                'variation_id' => '3000',
                'plan' => 'MTN Data 3GB - 30 Days',
                'price' => 1050
            ],

            [
                'network_id' => 1,
                'variation_id' => '5000',
                'plan' => 'MTN Data 5GB - 30 Days',
                'price' => 1650
            ],

            [
                'network_id' => 1,
                'variation_id' => '10000',
                'plan' => 'MTN Data 10GB - 30 Days',
                'price' => 3500
            ],

            [
                'network_id' => 1,
                'variation_id' => 'mtn-20hrs-1500',
                'plan' => 'MTN Data 6GB - 7 Days',
                'price' => 1650
            ],

            [
                'network_id' => 1,
                'variation_id' => 'mtn-30gb-8000',
                'plan' => 'MTN Data 30GB - 30 Days',
                'price' => 1650
            ],

            [
                'network_id' => 1,
                'variation_id' => 'mtn-40gb-10000 ',
                'plan' => 'MTN Data 5GB - 30 Days',
                'price' => 1650
            ],

            [
                'network_id' => 1,
                'variation_id' => 'mtn-75gb-15000',
                'plan' => 'MTN Data 5GB - 30 Days',
                'price' => 1650
            ],
        ];
    }

    public function getAirtelData()
    {
        return [
            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL500MB',
                'plan' => 'Airtel Data 500MB - 30 Days',
                'price' => '300'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'airt-330x',
                'plan' => 'Airtel Data 1GB - 1 Day',
                'price' => '345'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'airt-1650-2',
                'plan' => 'Airtel Data 6GB - 7 Days',
                'price' => '300'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL1GB',
                'plan' => 'Airtel Data 1GB - 30 Days',
                'price' => '450'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL2GB',
                'plan' => 'Airtel Data 2GB - 30 Days',
                'price' => '650'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL5GB',
                'plan' => 'Airtel Data 5GB - 30 Days',
                'price' => '1450'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL10GB',
                'plan' => 'Airtel Data 10GB - 30 Days',
                'price' => '2650'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL15GB',
                'plan' => 'Airtel Data 15GB - 30 Days',
                'price' => '3850'
            ],

            [
                'network_id' => 2,
                'variation_id' => 'AIRTEL20GB',
                'plan' => 'Airtel Data 20GB - 30 Days',
                'price' => '5000'
            ]
        ];
    }
}