<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;

class PackageUtilityController extends Controller
{
    public function index(Package $package)
    {
        $utility = $package->utility;

        return $this->success(new UtilityResource($utility));
    }
}
