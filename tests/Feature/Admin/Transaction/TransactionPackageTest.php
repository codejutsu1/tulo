<?php

use App\Models\Transaction;
use App\Http\Resources\PackageResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    
    $this->package1 = Transaction::factory()->create();
    $this->package2 = Transaction::factory()->create(['package_id'=>20]);
});


test('admin can access the Transaction Package endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/packages')
                    ->assertOk();
});

test('user can not access the Transaction Package endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/packages')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Transaction Package endpoint', function () {
    $response = $this->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/packages')
                    ->assertStatus(302);
});

test('Transaction Package endpoint returns the package associated with a transaction', function() {
    $package = Transaction::findOrFail(1)->package;

    $resource = new PackageResource($package);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package1->identifier.'/packages')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Transaction Package endpoint does not return the package associated with another transaction', function() {
    $package = Transaction::findOrFail(1)->package;

    $resource = new PackageResource($package);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/transactions/'.$this->package2->identifier.'/packages')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});