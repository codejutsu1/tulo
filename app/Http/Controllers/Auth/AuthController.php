<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
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

        return $this->createSuccess(new UserResource($user), $token, 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid Login Details', 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        return $this->success(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Successfully logged out.');
    }
}
