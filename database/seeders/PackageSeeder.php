<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use App\Services\UtilityService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::truncate();

        $utility = new UtilityService();

        foreach($utility->getMtnPlan() as $data){
            $data['profit'] = $data['price'] - $data['original_price'];
             
            Package::create($data);
        }

        foreach($utility->getAirtelPlan() as $data){
            Package::create($data);
        }
    }
}
