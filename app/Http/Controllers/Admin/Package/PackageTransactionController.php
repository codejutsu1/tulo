<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageTransactionController extends Controller
{
    public function index(Package $package)
    {
        $transactions = $package->transactions;

        return $transactions;
    }
}
