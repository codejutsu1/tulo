<?php

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group Package endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/packages')
                    ->assertOk();
});

test('user can not access the Group Package endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/packages')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group Package endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/packages')
                    ->assertStatus(302);
});
