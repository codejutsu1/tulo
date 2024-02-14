<?php

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/utilities')
                    ->assertOk();
});

test('user can not access the Group Utility endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/utilities')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group Utility endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/utilities')
                    ->assertStatus(302);
});
