<?php

use App\Models\Transaction;
use App\Http\Resources\UtilityResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    
    $this->package1 = Transaction::factory()->create();
    $this->package2 = Transaction::factory()->create(['package_id'=>20]);
});


test('admin can access the Transaction Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/utilities')
                    ->assertOk();
});

test('user can not access the Transaction Utility endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/utilities')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Transaction Utility endpoint', function () {
    $response = $this->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/utilities')
                    ->assertFound();
});

test('Transaction Utility endpoint returns the utility associated with a transaction', function() {
    $utilities = Transaction::findOrFail(1)
                        ->package()
                        ->whereHas('utility')
                        ->with('utility')
                        ->get()
                        ->pluck('utility')
                        ->unique()
                        ->values();

    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/utilities')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Transaction Utility endpoint does not return the utility associated with another transaction', function() {
    $utilities = Transaction::findOrFail(1)
                        ->package()
                        ->whereHas('utility')
                        ->with('utility')
                        ->get()
                        ->pluck('utility')
                        ->unique()
                        ->values();

    $resource = UtilityResource::collection($utilities);
    
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package2->identifier.'/utilities')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});