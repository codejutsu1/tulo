<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;

class GroupUtilityController extends Controller
{
    public function index(Group $group)
    {
        return $this->success(UtilityResource::collection($group->utilities()->get()->unique('name')));
    }
}
