<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilityGroupController extends Controller
{
    public function index(Utility $utility)
    {
        return $utility->group;
    }
}
