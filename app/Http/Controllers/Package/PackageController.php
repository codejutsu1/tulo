<?php

namespace App\Http\Controllers\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Services\PackageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Http\Requests\StorePackageRequest;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();

        return $this->success(PackageResource::collection($packages));
    }

    public function store(StorePackageRequest $request)
    {
        $packageService = new PackageService();

        $response = $packageService->storePackage($request->validated());

        return $response;
    }

    public function show(Package $package)
    {
        return $this->success(new PackageResource($package));
    }

}
