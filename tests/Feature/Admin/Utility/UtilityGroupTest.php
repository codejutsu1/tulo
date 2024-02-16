<?php

use App\Models\Utility;
use App\Http\Resources\GroupResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Utility Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/groups')
                    ->assertOk();
});

test('user can not access the Utility Group endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/utilities/1/groups')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Utility Group endpoint', function () {
    $response = $this->get('/api/v1/admin/utilities/1/groups')
                    ->assertStatus(302);
});


test('Utility Group Endpoint returns groups associated with Utility', function() {
    $group = Utility::findOrFail(1)->group;
    
    $resource = new GroupResource($group);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/groups')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Utility Group Endpoint does not return groups associated with Utility', function() {
    $group = Utility::findOrFail(1)->group;
    
    $resource = new GroupResource($group);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/10/groups')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});
