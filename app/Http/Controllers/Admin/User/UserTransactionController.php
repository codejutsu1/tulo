<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;

class UserTransactionController extends Controller
{
    public function index(User $user)
    {
        $transactions = $user->transactions;

        return $this->success(TransactionResource::collection($transactions));
    }
}
