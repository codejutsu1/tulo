<?php

namespace App\Http\Controllers\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();

        return $this->success(PackageResource::collection($packages));
    }

    public function show(Package $package)
    {
        return $this->success(PackageResource::collection($package));
    }
}
