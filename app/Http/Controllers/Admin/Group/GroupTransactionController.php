<?php

namespace App\Http\Controllers\Admin\Group;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupTransactionController extends Controller
{
    public function index(Group $group)
    {
        $transactions = $group->utilities()
                                ->with('packages.transactions')
                                ->get()
                                ->pluck('packages')
                                ->collapse()
                                ->pluck('transactions')
                                ->collapse()
                                ->unique()
                                ->values();

        return $transactions;
    }
}
