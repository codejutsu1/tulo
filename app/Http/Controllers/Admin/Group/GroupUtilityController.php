<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupUtilityController extends Controller
{
    public function index(Group $group)
    {
        return $group->utilities;
    }
}
