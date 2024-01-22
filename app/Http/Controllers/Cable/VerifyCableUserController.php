<?php

namespace App\Http\Controllers\Cable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCableRequest;
use App\Services\VerifyUtilityUserService;

class VerifyCableUserController extends Controller
{
    public function store(StoreCableRequest $request)
    {
        $verifyUser = new VerifyUtilityUserService();
        
        $response = $verifyUser->verifyUser($request->validated());

        return $response;
    }
}
