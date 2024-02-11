<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionGroupController extends Controller
{
    public function index(Transaction $transaction)
    {
        $group = $transaction->package()
                            ->with('utility.group')
                            ->get()
                            ->pluck('utility.group');

        return $group;
    }
}
