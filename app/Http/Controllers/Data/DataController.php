<?php

namespace App\Http\Controllers\Data;

use App\Models\Data;
use Illuminate\Http\Request;
use App\Services\DataService;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Http\Requests\StoreDataRequest;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPackages = Package::all();

        return $this->success(DataResource::collection($dataService));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataRequest $request)
    {   
        $dataService = new DataService();
        
        $response = $dataService->buyData($request->validated());

        return response()->json($response);
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
