<?php

use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
   
    $this->user1 = Transaction::factory()->create();
    $this->user2 = Transaction::factory()->create();
});

test('admin can access the User Transaction endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/'.$this->user1->user->identifier.'/transactions')
                    ->assertOk();
});

test('user can not access the User Transaction endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/users/'.$this->user1->user->identifier.'/transactions')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the User Transaction endpoint', function () {
    $response = $this->get('/api/v1/admin/users/'.$this->user1->user->identifier.'/transactions')
                    ->assertFound();
});

test('User Transaction returns all transactions associated to a user', function() {
    $transactions = User::findOrFail($this->user1->user_id)->transactions;

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user1->user->identifier.'/transactions')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});


test('User Transaction does not return transactions associated to another user', function() {
    $transactions = User::findOrFail($this->user1->user_id)->transactions;

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user2->user->identifier.'/transactions')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});