<?php

use App\Models\Transaction;
use App\Http\Resources\GroupResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    
    $this->package1 = Transaction::factory()->create();
    $this->package2 = Transaction::factory()->create(['package_id'=>20]);
});


test('admin can access the Transaction Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/groups')
                    ->assertOk();
});

test('user can not access the Transaction Group endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/groups')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Transaction Group endpoint', function () {
    $response = $this->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/groups')
                    ->assertFound();
});

test('Transaction Group endpoint returns the group associated with a transaction', function() {
    $group = Transaction::findOrFail(1)
                        ->package()
                        ->with('utility.group')
                        ->get()
                        ->pluck('utility.group');

    $resource = GroupResource::collection($group);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/groups')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Transaction Group endpoint does not return the group associated with another transaction', function() {
    $group = Transaction::findOrFail(1)
                        ->package()
                        ->with('utility.group')
                        ->get()
                        ->pluck('utility.group');

$resource = GroupResource::collection($group);
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package2->identifier.'/groups')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});