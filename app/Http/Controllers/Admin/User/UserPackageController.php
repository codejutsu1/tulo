<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class UserPackageController extends Controller
{
    public function index(User $user)
    {
        $packages = $user->transactions()
                        ->whereHas('package')
                        ->with('package')
                        ->get()
                        ->pluck('package');

        return $this->success(PackageResource::collection($packages));
    }
}
