<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;

class PackageGroupController extends Controller
{
    public function index(Package $package)
    {
        $groups = $package->utility()
                        ->whereHas('group')
                        ->with('group')
                        ->get()
                        ->pluck('group')
                        ->unique()
                        ->values();

        return $this->success(GroupResource::collection($groups));
    }
}
