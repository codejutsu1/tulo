<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupUserController extends Controller
{
    public function index(Group $group)
    {
        // $users = $group->utilities()
        //                 ->whereHas('packages.transactions')
        //                 ->with('packages.transactions')
        //                 ->get()
        //                 ->pluck('transactions');

        // return $users;
    }
}
