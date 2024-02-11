<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionUtilityController extends Controller
{
    public function index(Transaction $transaction)
    {
        $utility = $transaction->package()
                                ->whereHas('utility')
                                ->with('utility')
                                ->get()
                                ->pluck('utility');
        
        return $utility;
    }
}
