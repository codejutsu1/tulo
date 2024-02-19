<?php

use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    $this->data = ['name' => 'John Doe'];
});


test('A user can access the profile', function() {
    $response = $this->actingAs($this->user)
                    ->get(route('user.profile'))
                    ->assertOk();
});

test('An admin can access his profile', function() {
    $response = $this->actingAs($this->admin)
                    ->get(route('user.profile'))
                    ->assertOk();
});

test('An unauthenticated cannot access a user profile', function() {
    $response = $this->get(route('user.profile'))
                    ->assertFound();
});

test('A user can view his details', function() {
    $user = New UserResource($this->user);

    $response = $this->actingAs($this->user)
                    ->get(route('user.profile'))
                    ->assertOk()
                    ->assertJson(
                        $user->response()->getData(true)
                    );
});

test('A user cannot access another profile', function() {
    $user = New UserResource($this->admin);

    $response = $this->actingAs($this->user)
                    ->get(route('user.profile'))
                    ->assertOk()
                    ->assertJsonMissing(
                        $user->response()->getData(true)
                    );
});

test('A user can update his profile', function() {
   $response = $this->actingAs($this->user)
                    ->putJson(route('user.update'), $this->data)
                    ->assertOk()
                    ->assertJson([
                        "data" => $this->data
                    ]);
});

test('An unauthenticated user cannot update his profile', function() {
    $response = $this->putJson(route('user.update'), $this->data)
                    ->assertUnauthorized();
});

test('A user can delete his profile', function() {
    $response = $this->actingAs($this->user)
                    ->deleteJson(route('user.delete'))
                    ->assertNocontent();
});

test('An unauthenticated user cannot delete his profile', function() {
    $response = $this->deleteJson(route('user.delete'))
                    ->assertUnauthorized();
});