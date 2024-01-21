<?php

namespace Database\Seeders;

use App\Models\Data;
use App\Services\DataArrayService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Data::truncate();

        $dataService = new DataArrayService();

        foreach($dataService->getMtnData() as $data){
            Data::create($data);
        }

        foreach($dataService->getAirtelData() as $data){
            Data::create($data);
        }
    }
}
