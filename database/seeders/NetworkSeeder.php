<?php

namespace Database\Seeders;

use App\Models\Network;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Network::truncate();
        
        $networks  = [
            'mtn',
            'airtel',
            'glo',
            'etisalat'
        ];

        foreach($networks as $network) {
            Network::create([
                'network' => $network,
            ]);
        }
    }
}
