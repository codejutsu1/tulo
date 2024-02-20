<?php

use App\Models\Package;
use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});


test('admin can access the Package User endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/users')
                    ->assertOk();
});

test('user can not access the Package User endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/packages/1/users')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Package User endpoint', function () {
    $response = $this->get('/api/v1/admin/packages/1/users')
                    ->assertFound();
});

test('Package user endpoints return users associated with a package', function() {
    $users = Package::findOrFail(1)
                    ->transactions()
                    ->whereHas('user')
                    ->with('user')
                    ->get()
                    ->pluck('user');

    $resource = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/users')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Package user endpoints does not return users associated with another package', function() {
    $users = Package::findOrFail(1)
                    ->transactions()
                    ->whereHas('user')
                    ->with('user')
                    ->get()
                    ->pluck('user');

    $resource = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/2/users')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});