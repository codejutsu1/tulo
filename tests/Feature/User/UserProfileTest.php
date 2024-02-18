<?php

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});


test('A user can access the profile', function() {
    $response = $this->actingAs($this->user)
                    ->get(route('user.profile'))
                    ->assertOk();
});

test('An unauthenticated cannot access a user profile', function() {
    $response = $this->get(route('user.profile'))
                    ->assertFound();
});

test('A user can view his details', function() {
    $response = $this->actingAs($this->user)
                    ->get(route('user.profile'))
                    ->assertOk();
});
