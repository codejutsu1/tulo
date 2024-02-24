<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Services\PhoneService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckNumberRequest;

class NetworkProviderController extends Controller
{
    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function index(CheckNumberRequest $request)
    {
        $networkProvider = $this->phoneService->networkProvider($request->phoneNumber);

        return $this->success(['networkProvider' => $networkProvider]);
    }
}
