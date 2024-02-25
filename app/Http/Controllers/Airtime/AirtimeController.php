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
    public function __construct(
        private AirtimeService $airtimeService
    ){}
    
    public function store(StoreAirtimeRequest $request)
    {
        $response = $this->airtimeService->buyAirtime($request->validated());

        return $response;
    }
}
