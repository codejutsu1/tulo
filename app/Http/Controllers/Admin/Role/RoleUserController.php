<?php

namespace App\Http\Controllers\Admin\Role;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class RoleUserController extends Controller
{
    public function index(Role $role)
    {
        $users = $role->users;

        return $this->success(UserResource::collection($users));
    }
}
