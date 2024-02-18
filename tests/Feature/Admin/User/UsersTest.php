<?php

use App\Models\User;
use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    $this->data = [
        'name' => 'John Joe',
        'email' => 'john@joe.com',
        'password' => 'mypassword',
        'phone_number' => '2340909090922',
        'source' => 'Egg Source'
    ];
});

test('An admin can access the users index route', function() {
    $response = $this->actingAs($this->admin)
                        ->get(route('users.index'))
                        ->assertOk();
});

test('A user cannot access the users index route', function(){
    $response = $this->actingAs($this->user)
                    ->get(route('users.index'))
                    ->assertForbidden();
});

test('An unauthenticated user cannot access the users index route', function(){
    $response = $this->get(route('users.index'))
                    ->assertFound();
});

test('The user index route returns all users', function() {
    $resource = UserResource::collection(User::all());

    $response = $this->actingAs($this->admin)
                        ->get(route('users.index'))
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('An admin can create a user', function() {
    $response = $this->actingAs($this->admin)
                        ->postJson(route('users.store'), $this->data)
                        ->assertCreated()
                        ->assertJson([
                            'code' => 201
                        ]);
});

test('A user cannot create a user', function() {
    $response = $this->actingAs($this->user)
                        ->postJson(route('users.store'), $this->data)
                        ->assertForbidden();
});

test('An unauthenticated user cannot create a user', function() {
    $response = $this->postJson(route('users.store'), $this->data)
                        ->assertUnauthorized(); //401 for post request
});

test('An admin can view a single user', function() {
    $resource = new UserResource($this->admin);

    $response = $this->actingAs($this->admin)
                        ->get(route('users.show', $this->admin->id))
                        ->assertOk()
                        ->assertJson(
                            $resource->response()->getData(true)
                        ); 
});

test('A user cannot view a single user', function() {
    $response = $this->actingAs($this->user)
                        ->get(route('users.show', $this->admin->id))
                        ->assertForbidden();
});

test('An unauthenticated user cannot view a single user', function() {
    $response = $this->get(route('users.show', $this->admin->id))
                    ->assertFound();
});

test('An admin can update a user', function() {
    $data = ['name' => 'john'];

    $response = $this->actingAs($this->admin)
                        ->putJson(route('users.update', $this->user->id), $data)
                        ->assertOk();
});

test('A user cannot update a user', function() {
    $data = ['name' => 'john'];

    $response = $this->actingAs($this->user)
                        ->putJson(route('users.update', $this->user->id), $data)
                        ->assertForbidden();
});

test('An unauthenticated user cannot update a user', function() {
    $data = ['name' => 'john'];

    $response = $this->putJson(route('users.update', $this->user->id), $data)
                        ->assertUnauthorized();
});

test('An admin can delete a user', function() {
    $response = $this->actingAs($this->admin)
                    ->deleteJson(route('users.destroy', $this->user->id))
                    ->assertNoContent();
});

test('A user cannot delete a user', function() {
    $response = $this->actingAs($this->user)
                    ->deleteJson(route('users.destroy', $this->user->id))
                    ->assertForbidden();
});

test('An unauthenticated user cannot delete a user', function() {
    $response = $this->deleteJson(route('users.destroy', $this->user->id))
                    ->assertUnauthorized();
});