<?php

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group User endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/users')
                    ->assertOk();
});

test('user can not access the Group User endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/users')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group User endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/users')
                    ->assertStatus(302);
});
