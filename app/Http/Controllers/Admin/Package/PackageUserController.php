<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class PackageUserController extends Controller
{
    public function index(Package $package)
    {
        $users = $package->transactions()
                        ->whereHas('user')
                        ->with('user')
                        ->get()
                        ->pluck('user');

        return $this->success(new UserResource($users));
    }
}
