<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;

class TransactionGroupController extends Controller
{
    public function index(Transaction $transaction)
    {
        $groups = $transaction->package()
                            ->with('utility.group')
                            ->get()
                            ->pluck('utility.group');

        return $this->success(GroupResource::collection($groups));
    }
}
