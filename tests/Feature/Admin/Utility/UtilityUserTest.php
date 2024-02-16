<?php

use App\Models\Utility;
use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Utility User endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/users')
                    ->assertOk();
});

test('user can not access the Utility User endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/utilities/1/users')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Utility User endpoint', function () {
    $response = $this->get('/api/v1/admin/utilities/1/users')
                    ->assertStatus(302);
});


test('Utility User Endpoint returns users associated with Utility', function() {
    $users = Utility::findOrFail(1)
                        ->packages()
                        ->with('transactions.user')
                        ->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->pluck('user')
                        ->unique()
                        ->values(); 
    
    $resource = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/users')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});


test('Utility User Endpoint does not returns users associated with another Utility', function() {
    $users = Utility::findOrFail(1)
                        ->packages()
                        ->with('transactions.user')
                        ->get()
                        ->pluck('transactions')
                        ->collapse()
                        ->pluck('user')
                        ->unique()
                        ->values(); 
    
    $resource = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/2/users')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});