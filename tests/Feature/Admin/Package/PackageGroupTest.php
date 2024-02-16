<?php

use App\Models\Package;
use App\Http\Resources\GroupResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Package Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/groups')
                    ->assertOk();
});

test('user can not access the Package Group endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/packages/1/groups')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Package Group endpoint', function () {
    $response = $this->get('/api/v1/admin/packages/1/groups')
                    ->assertStatus(302);
});

test('Package Group endpoint returns group associated with a package', function() {
    $group = Package::findOrFail(2)
                    ->utility()
                    ->whereHas('group')
                    ->with('group')
                    ->get()
                    ->pluck('group')
                    ->unique()
                    ->values();

    $resource = GroupResource::collection($group);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/2/groups')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Package Group endpoint does not return group associated with another package', function() {
    $group = Package::findOrFail(2)
                    ->utility()
                    ->whereHas('group')
                    ->with('group')
                    ->get()
                    ->pluck('group')
                    ->unique()
                    ->values();

    $resource = GroupResource::collection($group);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/20/groups')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});