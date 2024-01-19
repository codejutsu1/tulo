<?php

namespace App\Http\Controllers\Network;

use Illuminate\Http\Request;
use App\Services\PhoneService;
use App\Http\Controllers\Controller;

class FormatNumberController extends Controller
{
    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function index(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric|min:10'
        ]);

        $formattedNumber = $this->phoneService->formatNumber($request->number);

        return $this->success(['number' => $formattedNumber]);
    }
}
