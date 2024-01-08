<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser($user): User
    {
        $user['username'] = User::getUniqueUsername($user['name']);
        return User::create($user);
    }
}