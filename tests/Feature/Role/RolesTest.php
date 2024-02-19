<?php

use App\Models\Role;
use App\Http\Resources\RoleResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    $this->data = ['name' => 'Hacker'];
    $this->role = Role::findOrFail(2);
});

test('An admin can access the role index route', function() {
    $response = $this->actingAs($this->admin)
                    ->get(route('roles.index'))
                    ->assertOk();
});

test('A user cannot access the role index route', function() {
    $response = $this->actingAs($this->user)
                    ->get(route('roles.index'))
                    ->assertForbidden();
});

test('An unauthenticated user cannot access the role index route', function() {
    $response = $this->get(route('roles.index'))
                    ->assertFound();
});

test('An admin can see roles in the index route', function() {
    $roles = RoleResource::collection(Role::all());

    $response = $this->actingAs($this->admin)
                    ->get(route('roles.index'))
                    ->assertOk()
                    ->assertJson(
                        $roles->response()->getData(true)
                    );
});

test('An admin can create a new role', function() {
    $response = $this->actingAs($this->admin)
                    ->postJson(route('roles.store'), $this->data)
                    ->assertCreated()
                    ->assertJson([
                        "data" => $this->data
                    ]);
});

test('A user cannot create a new role', function() {
    $response = $this->actingAs($this->user)
                    ->postJson(route('roles.store'), $this->data)
                    ->assertForbidden();
});

test('An unauthenticated user cannot create a new role', function() {
    $response = $this->postJson(route('roles.store'), $this->data)
                    ->assertUnauthorized();
});

test('Admin can view a single role', function() {
    $resource = new RoleResource($this->role);

    $response = $this->actingAs($this->admin)
                    ->get(route('roles.show', $this->role->id))
                    ->assertOk()
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('A user cannot view a single role', function() {
    $response = $this->actingAs($this->user)
                    ->get(route('roles.show', $this->role->id))
                    ->assertForbidden();
});

test('An authenticated user cannot view a single role', function() {
    $response = $this->get(route('roles.show', $this->role->id))
                    ->assertFound();
});

test('An admin can update a role', function() {
    $response = $this->actingAs($this->admin)
                    ->putJson(route('roles.update', $this->role->id), $this->data)
                    ->assertOk()
                    ->assertJson([
                        "data" => $this->data
                    ]);
});

test('A user cannot update a role', function() {
    $response = $this->actingAs($this->user)
                    ->putJson(route('roles.update', $this->role->id), $this->data)
                    ->assertForbidden();
});

test('An unauthenticated user cannot update a role', function() {
    $response = $this->putJson(route('roles.update', $this->role->id), $this->data)
                    ->assertUnauthorized();
});

test('An admin can delete a role', function() {
    $response = $this->actingAs($this->admin)
                    ->deleteJson(route('roles.destroy', $this->role->id))
                    ->assertNoContent();
});

test('An user cannot delete a role', function() {
    $response = $this->actingAs($this->user)
                    ->deleteJson(route('roles.destroy', $this->role->id))
                    ->assertForbidden();
});

test('An unauthenticated user cannot delete a role', function() {
    $response = $this->deleteJson(route('roles.destroy', $this->role->id))
                    ->assertUnauthorized();
});