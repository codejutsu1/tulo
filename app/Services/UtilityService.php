<?php

namespace App\Services;

class UtilityService {

    public function getMtnPlan() {
        return [ 
            [
                'utility_id' => 1,
                'variation_id' => '500',
                'plan' => 'MTN Data 500MB - 30 Days',
                'original_price' => 189,
                'price' => 350
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'M1024',
                'plan' => 'MTN Data 1GB - 30 Days',
                'original_price' => 299,
                'price' => 450
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'M2024',
                'plan' => 'MTN Data 2GB - 30 Days',
                'original_price' => 599,
                'price' => 750
            ],

            [
                'utility_id' => 1,
                'variation_id' => '3000',
                'plan' => 'MTN Data 3GB - 30 Days',
                'original_price' => 899,
                'price' => 1050
            ],

            [
                'utility_id' => 1,
                'variation_id' => '5000',
                'plan' => 'MTN Data 5GB - 30 Days',
                'original_price' => 1499,
                'price' => 1650
            ],

            [
                'utility_id' => 1,
                'variation_id' => '10000',
                'plan' => 'MTN Data 10GB - 30 Days',
                'original_price' => 2999,
                'price' => 3500
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'mtn-20hrs-1500',
                'plan' => 'MTN Data 6GB - 7 Days',
                'original_price' => 1489,
                'price' => 1650
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'mtn-30gb-8000',
                'plan' => 'MTN Data 30GB - 30 Days',
                'original_price' => 7899,
                'price' => 8200
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'mtn-40gb-10000 ',
                'plan' => 'MTN Data 5GB - 30 Days',
                'original_price' => 9859,
                'price' => 11200
            ],

            [
                'utility_id' => 1,
                'variation_id' => 'mtn-75gb-15000',
                'plan' => 'MTN Data 5GB - 30 Days',
                'original_price' => 14899,
                'price' => 15200
            ],
        ];
    }

    public function getAirtelPlan()
    {
        return [
            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL500MB',
                'plan' => 'Airtel Data 500MB - 30 Days',
                'original_price' => 149,
                'price' => 300
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'airt-330x',
                'plan' => 'Airtel Data 1GB - 1 Day',
                'original_price' => 325,
                'price' => 345
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'airt-1650-2',
                'plan' => 'Airtel Data 6GB - 7 Days',
                'original_price' => 1629,
                'price' => 1800
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL1GB',
                'plan' => 'Airtel Data 1GB - 30 Days',
                'original_price' => 249,
                'price' => 450
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL2GB',
                'plan' => 'Airtel Data 2GB - 30 Days',
                'original_price' => 499,
                'price' => 650
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL5GB',
                'plan' => 'Airtel Data 5GB - 30 Days',
                'original_price' => 1249,
                'price' => 1450
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL10GB',
                'plan' => 'Airtel Data 10GB - 30 Days',
                'original_price' => 2499,
                'price' => 2650
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL15GB',
                'plan' => 'Airtel Data 15GB - 30 Days',
                'original_price' => 3699,
                'price' => 3850
            ],

            [
                'utility_id' => 2,
                'variation_id' => 'AIRTEL20GB',
                'plan' => 'Airtel Data 20GB - 30 Days',
                'original_price' => 4899,
                'price' => 5000
            ]
        ];
    }

    public function getGotvPlan()
    {
        return [
            [
                'utility_id' => 5,
                'variation_id' => 'gotv-smallie',
                'plan' => 'GOTV Smallie',
                'original_price' => 1300,
                'price' => 1400,
                'service_id' => 'gotv', 
            ],

            [
                'utility_id' => 5,
                'variation_id' => 'gotv-jinja',
                'plan' => 'GOTV Jinja',
                'original_price' => 2700,
                'price' => 2800,
                'service_id' => 'gotv', 
            ],

            [
                'utility_id' => 5,
                'variation_id' => 'gotv-jolli',
                'plan' => 'GOTV Jolli',
                'original_price' => 3950,
                'price' => 4050,
                'service_id' => 'gotv', 
            ],

            [
                'utility_id' => 5,
                'variation_id' => 'gotv-max',
                'plan' => 'GOTV Max',
                'original_price' => 5700,
                'price' => 5800,
                'service_id' => 'gotv', 
            ],

            [
                'utility_id' => 5,
                'variation_id' => 'gotv-supa',
                'plan' => 'GOTV Supa',
                'original_price' => 7600,
                'price' => 7700,
                'service_id' => 'gotv', 
            ],
        ];
    }
}