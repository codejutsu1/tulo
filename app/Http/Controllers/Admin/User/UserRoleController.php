<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;

class UserRoleController extends Controller
{
    public function index(User $user)
    {
        return $this->success(new RoleResource($user->role));
    }
}
