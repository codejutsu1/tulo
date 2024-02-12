<?php

namespace App\Http\Controllers\Admin\Utility;

use App\Models\Utility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;

class UtilityGroupController extends Controller
{
    public function index(Utility $utility)
    {
        return $this->success(new GroupResource($utility->group));
    }
}
