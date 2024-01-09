<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function createUser($user): User
    {
        $user['username'] = User::getUniqueUsername($user['name']);

        $user = User::create($user);

        event(new Registered($user));

        return $user;
    }
}