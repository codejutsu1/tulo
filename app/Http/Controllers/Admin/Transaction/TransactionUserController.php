<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class TransactionUserController extends Controller
{
    public function index(Transaction $transaction)
    {
        $user = $transaction->user;

        return $this->success(new UserResource($user));
    }
}
