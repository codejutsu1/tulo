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
        Utility::truncate();
        
        $data = [
            'mtn',
            'airtel',
            'etisalat',
            'glo',
        ];

        $cables = [
            'gotv',
            'dstv',
            'startimes',
        ];

        $utilities = [
            'abuja-electric',
            'eko-electric',
            'ibadan-electric',
            'ikeja-electric',
            'jos-electric',
            'kaduna-electric',
            'kano-electric',
            'portharcourt-electric',
        ];

        foreach($data as $dat){
            Utility::create([
                'group_id' => 1,
                'name' => $data
            ]);
        }

        foreach($cables as $cable){
            Utility::create([
                'group_id' => 2,
                'name' => $cable,
            ]);
        }

        foreach($utilities as $utility){
            Utility::create([
                'group_id' => 3,
                'name' => $utility,
            ]);
        }
    }
}
