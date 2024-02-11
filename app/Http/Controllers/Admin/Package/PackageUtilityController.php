<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageUtilityController extends Controller
{
    public function index(Package $package)
    {
        $utility = $package->utility;

        return $utility;
    }
}
