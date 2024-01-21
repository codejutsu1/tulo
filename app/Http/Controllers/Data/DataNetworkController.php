<?php

namespace App\Http\Controllers\Data;

use App\Models\Network;
use Illuminate\Http\Request;
use App\Services\PhoneService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckNumberRequest;

class DataNetworkController extends Controller
{
    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function index(CheckNumberRequest $request)
    {
        $networkProvider = $this->phoneService->networkProvider($request->number);


        $dataServices = Network::where('network', $networkProvider)
                                ->with('data', function($query) {
                                    $query->select(['network_id', 'variation_id', 'plan', 'price']);
                                })
                                ->first();
        
        return $this->success($dataServices->data);
    }
}
