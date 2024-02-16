<?php

use App\Models\Group;
use App\Models\Transaction;
use App\Http\Resources\TransactionResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Group Transaction endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/transactions')
                    ->assertOk();
});

test('user can not access the Group Transaction endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/transactions')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group Transaction endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/transactions')
                    ->assertStatus(302);
});

test('Group Transaction endpoint returns transactions associated with data group', function() {    
    $transactions = Group::findOrFail(1)
                                ->utilities()
                                ->with('packages.transactions')
                                ->get()
                                ->pluck('packages')
                                ->collapse()
                                ->pluck('transactions')
                                ->collapse()
                                ->unique()
                                ->values();

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/1/transactions')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group Transaction endpoint returns transactions associated with cable group', function() {    
    $transactions = Group::findOrFail(2)
                                ->utilities()
                                ->with('packages.transactions')
                                ->get()
                                ->pluck('packages')
                                ->collapse()
                                ->pluck('transactions')
                                ->collapse()
                                ->unique()
                                ->values();

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/2/transactions')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group Transaction endpoint returns transactions associated with utilities group', function() {    
    $transactions = Group::findOrFail(3)
                                ->utilities()
                                ->with('packages.transactions')
                                ->get()
                                ->pluck('packages')
                                ->collapse()
                                ->pluck('transactions')
                                ->collapse()
                                ->unique()
                                ->values();

    $resource = TransactionResource::collection($transactions);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/3/transactions')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

