<?php

use App\Models\Utility;
use App\Http\Resources\UtilityResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                        ->get(route('utility'))
                        ->assertOk();
});

test('unauthenticated users can not access the Utility endpoint', function(){
    $response = $this->get(route('utility'))
                        ->assertFound();
});

test('authenticated users cannot access the Utility endpoint', function(){
    $response = $this->actingAs($this->user)
                    ->get(route('utility'))
                    ->assertForbidden();
});


test('Utility endpoints returns data', function() {
    $resource = UtilityResource::collection(Utility::all());

    $response = $this->actingAs($this->admin)
                    ->get(route('utility'))
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});