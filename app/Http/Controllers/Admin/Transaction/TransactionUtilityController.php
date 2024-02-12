<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;

class TransactionUtilityController extends Controller
{
    public function index(Transaction $transaction)
    {
        $utilities = $transaction->package()
                                ->whereHas('utility')
                                ->with('utility')
                                ->get()
                                ->pluck('utility')
                                ->unique()
                                ->values();
        
        return $this->success(UtilityResource::collection($utilities));
    }
}
