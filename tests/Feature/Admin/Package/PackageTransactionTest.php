<?php

use App\Models\Package;
use App\Http\Resources\TransactionResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});


test('admin can access the Package Transaction endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/transactions')
                    ->assertOk();
});

test('user can not access the Package Transaction endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/packages/1/transactions')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Package Transaction endpoint', function () {
    $response = $this->get('/api/v1/admin/packages/1/transactions')
                    ->assertStatus(302);
});

test('Package Transaction endpoints return transactions associated with a package', function() {
    $transactions = Package::findOrFail(1)->transactions;

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/transactions')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Package Transaction endpoint does not return transactions associated with another package', function() {
    $transactions = Package::findOrFail(1)->transactions;

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/4/transactions')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});