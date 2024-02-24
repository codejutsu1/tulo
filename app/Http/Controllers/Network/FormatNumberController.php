<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Services\PhoneService;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckNumberRequest;

class FormatNumberController extends Controller
{
    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function index(CheckNumberRequest $request)
    {
        $formattedNumber = $this->phoneService->formatNumber($request->phoneNumber);

        return $this->success(['number' => $formattedNumber]); //09122233356
    }
}
