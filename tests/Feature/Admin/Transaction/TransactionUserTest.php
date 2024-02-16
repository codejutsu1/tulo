<?php

use App\Models\Transaction;
use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    
    $this->package1 = Transaction::factory()->create();
    $this->package2 = Transaction::factory()->create();
});


test('admin can access the Transaction User endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/users')
                    ->assertOk();
});

test('user can not access the Transaction User endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/users')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Transaction User endpoint', function () {
    $response = $this->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/users')
                    ->assertStatus(302);
});

test('Transaction User endpoint returns the user associated with a transaction', function() {
    $user = Transaction::findOrFail(1)->user;

    $resource = new UserResource($user);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/users')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Transaction User endpoint does not return the user associated with another transaction', function() {
    $user = Transaction::findOrFail(1)->user;

    $resource = new UserResource($user);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package2->identifier.'/users')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});