<?php

namespace App\Http\Controllers\Data;

use App\Models\Group;
use App\Models\Package;
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
        $data = Group::with('packages')->where('name', 'data')->first();

        return $this->success(DataResource::collection($data->packages));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataRequest $request)
    {   
        $dataService = new DataService();
        
        $response = $dataService->buyData($request->validated());

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
