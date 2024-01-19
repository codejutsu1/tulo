<?php

namespace App\Http\Controllers\Airtime;

use Illuminate\Http\Request;
use App\Services\AirtimeService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirtimeRequest;

class AirtimeController extends Controller
{
    public function store(StoreAirtimeRequest $request)
    {
        return AirtimeService::buyAirtime($request);
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
