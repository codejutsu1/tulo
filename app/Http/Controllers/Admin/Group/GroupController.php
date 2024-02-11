<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return $this->success($groups);
    }
}
