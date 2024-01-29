<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Utility;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PackageResource;

class PackageService {
    use HttpResponses;

    public function storePackage($request): JsonResponse 
    {
        $utility_id = Utility::where('name', $request['utility'])->value('id');

        $request['utility_id'] = $utility_id;
        $request['profit'] = $request['price'] - $request['original_price'];


        $package = Package::create($request);

        return $this->success(new PackageResource($package));
    }
}