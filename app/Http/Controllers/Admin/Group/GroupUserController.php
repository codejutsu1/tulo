<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class GroupUserController extends Controller
{
    public function index(Group $group)
    {
        $users = $group->utilities()
                        ->whereHas('packages.transactions')
                        ->with('packages.transactions.user')
                        ->get()
                        ->pluck('packages')
                        ->collapse()
                        ->pluck('transactions')
                        ->collapse()
                        ->pluck('user')
                        ->unique('id')
                        ->values();

        return $this->success(UserResource::collection($users));
    }
}
