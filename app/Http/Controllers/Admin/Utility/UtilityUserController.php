<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilityUserController extends Controller
{
    public function index(Utility $utility)
    {
        $users = $utility->packages()
                        ->with('transactions.user')
                        ->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->pluck('user')
                        ->unique()
                        ->values();   
        
        return $users;
    }
}
