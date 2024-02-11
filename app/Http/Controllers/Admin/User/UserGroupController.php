<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGroupController extends Controller
{
    public function index(User $user)
    {
        $groups = $user->transactions()
                        ->whereHas('package')
                        ->with('package.utility.group') 
                        ->get()
                        ->pluck('package.utility.group')
                        ->unique()
                        ->values();

        return $groups;
    }
}
