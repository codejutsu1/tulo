<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageGroupController extends Controller
{
    public function index(Package $package)
    {
        $group = $package->utility()
                        ->whereHas('group')
                        ->with('group')
                        ->get()
                        ->pluck('group');

        return $group;
    }
}
