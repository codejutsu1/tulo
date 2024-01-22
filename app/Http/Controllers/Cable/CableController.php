<?php

namespace App\Http\Controllers\Cable;

use Illuminate\Http\Request;
use App\Services\CableService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCableRequest;

class CableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCableRequest $request)
    {
        $response = (new CableService)->buyCable($request->validated());

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
