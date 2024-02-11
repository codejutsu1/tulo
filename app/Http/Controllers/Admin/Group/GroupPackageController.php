<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class GroupPackageController extends Controller
{
    public function index(Group $group)
    {
        $packages = $group->utilities()
                        ->whereHas('packages')
                        ->with('packages')
                        ->get()
                        ->pluck('packages')
                        ->collapse();

        return $this->success(PackageResource::collection($packages));
    }
}
