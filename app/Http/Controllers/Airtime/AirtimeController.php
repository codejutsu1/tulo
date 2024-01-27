<?php

namespace App\Http\Controllers\Airtime;

use App\Mail\VtuError;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\AirtimeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreAirtimeRequest;

class AirtimeController extends Controller
{
    public function index()
    {
       
    }

    public function store(StoreAirtimeRequest $request)
    {
        $airtimeService = new AirtimeService();

        $response = $airtimeService->buyAirtime($request->validated());

        $test_reponse = '{
            "code":"success",
            "message":"Airtime successfully delivered",
            "data":{
                "network":"MTN",
                "phone":"07045461790",
                "amount":"NGN2000",
                "order_id":"3100"
            }
        }'; 

        $test= json_decode($test_reponse, true);

        $price = (integer) str_replace('NGN', '', $test['data']['amount']);

        $original_price = $airtimeService->originalPrice($price, $test['data']['network']);

        $profit = $airtimeService->profit($original_price, $price);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
