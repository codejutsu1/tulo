<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class PackageTransactionController extends Controller
{
    public function index(Package $package)
    {
        $transactions = $package->transactions;

        return $this->success(TransactionResource::collection($transactions));
    }
}
