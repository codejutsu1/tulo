<?php

use App\Models\Utility;
use App\Http\Resources\TransactionResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Utility Transaction endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/transactions')
                    ->assertOk();
});

test('user can not access the Utility Transaction endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/utilities/1/transactions')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Utility Transaction endpoint', function () {
    $response = $this->get('/api/v1/admin/utilities/1/transactions')
                    ->assertFound();
});

test('Utility transaction endpoint returns transaction data', function() {
    $transactions = Utility::findOrFail(1)
                            ->packages()
                            ->whereHas('transactions')
                            ->with('transactions')
                            ->get()
                            ->pluck('transactions')
                            ->collapse();
    
    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/utilities/1/transactions')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Utility transaction endpoint does not return transaction associated with another group', function() {
    $transactions = Utility::findOrFail(1)
                            ->packages()
                            ->whereHas('transactions')
                            ->with('transactions')
                            ->get()
                            ->pluck('transactions')
                            ->collapse();
    
    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/utilities/2/transactions')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});
