<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        
        return $this->success(new UserResource($user));
    }

    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        return $this->success(new UserResource($user));
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();

        return response()->noContent();
    }
}
