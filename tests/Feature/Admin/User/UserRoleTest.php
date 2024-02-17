<?php

use App\Models\User;
use App\Http\Resources\RoleResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the User Role endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/1/roles')
                    ->assertOk();
});

test('user can not access the User Role endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/users/1/roles')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the User Role endpoint', function () {
    $response = $this->get('/api/v1/admin/users/1/roles')
                    ->assertStatus(302);
});

test('User Role endpoint returns the role associated to a user', function() {
    $role = User::findOrFail(1)->role;

    $resource = new RoleResource($role);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/1/roles')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('User Role endpoint does not return the role associated to another user', function() {
    $role = User::findOrFail(1)->role;

    $resource = new RoleResource($role);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/2/roles')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});