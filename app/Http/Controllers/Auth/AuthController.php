<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return $this->success([new UserResource($user), 'token' => $token], 201);
    }
}
