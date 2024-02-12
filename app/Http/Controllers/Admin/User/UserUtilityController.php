<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;

class UserUtilityController extends Controller
{
    public function index(User $user)
    {
        $utilities = $user->transactions()
                            ->whereHas('package.utility')
                            ->get()
                            ->pluck('package.utility')
                            ->unique()
                            ->values();

        return $this->success(UtilityResource::collection($utilities));
    }
}
