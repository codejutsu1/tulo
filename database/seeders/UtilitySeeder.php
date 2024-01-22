<?php

namespace Database\Seeders;

use App\Models\Utility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UtilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $utilities = [
            'mtn',
            'airtel',
            'etisalat',
            'glo',
            'gotv',
            'dstv',
            'startimes',
            'abuja-electric',
            'eko-electric',
            'ibadan-electric',
            'ikeja-electric',
            'jos-electric',
            'kaduna-electric',
            'kano-electric',
            'portharcourt-electric',
        ];

        foreach($utilities as $utility){
            Utility::create(['name' => $utility]);
        }
    }
}
