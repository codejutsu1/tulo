<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class UtilityTransactionController extends Controller
{
    public function index(Utility $utility)
    {
        $transactions = $utility->packages()
                                ->whereHas('transactions')
                                ->with('transactions')
                                ->get()
                                ->pluck('transactions')
                                ->collapse();

        return $this->success(TransactionResource::collection($transactions));
    }
}
