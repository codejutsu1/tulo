<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class UtilityPackageController extends Controller
{
    public function index(Utility $utility)
    {
        $packages = $utility->packages;
        
        return $this->success(PackageResource::collection($packages));
    }
}
