<?php

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('unauthenticated users can not access the Group endpoint', function(){
    $response = $this->get(route('group'));

    $response->assertStatus(302);
});

test('admin can access the Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                        ->get(route('group'))
                        ->assertStatus(200);
});

test('authenticated users cannot access the Group endpoint', function(){
    $response = $this->actingAs($this->user)
                    ->get(route('group'))
                    ->assertStatus(403);
});
