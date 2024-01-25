<?php

namespace App\Http\Controllers\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilityController extends Controller
{
    public function index()
    {
        $utilities = Utility::all();

        return $this->success($utilities);
    }
}
