<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UtilityResource;

class UtilityController extends Controller
{
    public function index()
    {
        $utilities = Utility::all();

        return $this->success(UtilityResource::collection($utilities));
    }
}
