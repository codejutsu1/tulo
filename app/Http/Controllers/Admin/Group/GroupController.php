<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();

        return $this->success(GroupResource::collection($groups));
    }
}
