<?php

namespace App\Http\Controllers\Cable;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCableRequest;
use App\Services\VerifyUtilityUserService;

class VerifyCableUserController extends Controller
{
    use HttpResponses;
    
    public function store(StoreCableRequest $request)
    {
        $verifyUser = new VerifyUtilityUserService();
        
        $response = $verifyUser->verifyUser($request->validated());

        return $this->success($response);
    }
}
