<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;

class TransactionPackageController extends Controller
{
    public function index(Transaction $transaction)
    {
        $package = $transaction->package;

        return $this->success(new PackageResource($package));
    }
}
