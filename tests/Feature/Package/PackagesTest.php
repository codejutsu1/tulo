<?php

use App\Models\Package;
use App\Http\Resources\PackageResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    $this->createData = [
        'utility' => 'mtn',
        'variation_id' => 'random',
        'plan' => 'random',
        'original_price' => 283883,
        'price' => 23323,
        'profit' => 232323,
    ];

    $this->updateData = ['variation_id' => 'Hey'];

    $this->package = Package::findOrFail(1);
});

test('Admin can access the packages route', function(){
    $response = $this->actingAs($this->admin)
                    ->get(route('packages.index'))
                    ->assertOk();
});

test('A user can access the packages route', function(){
    $response = $this->actingAs($this->user)
                    ->get(route('packages.index'))
                    ->assertOk();
});

test('An unauthenticated user can access the packages route', function(){
    $response = $this->get(route('packages.index'))
                    ->assertOk();
});

test('Admin can create a package', function(){
    $response = $this->actingAs($this->admin)
                    ->postJson(route('packages.store'), $this->createData)
                    ->assertCreated();

    $package = new PackageResource(Package::firstWhere('variation_id', $this->createData['variation_id']));

    $response->assertJson(
        $package->response()->getData(true)
    );
});

test('A user cannot create a package', function(){
    $response = $this->actingAs($this->user)
                    ->postJson(route('packages.store'), $this->createData)
                    ->assertForbidden();
});

test('An unauthenticated user cannot create a package', function(){
    $response = $this->postJson(route('packages.store'), $this->createData)
                    ->assertUnauthorized();
});

test('Everyone can view a single user', function(){
    $package = new PackageResource($this->package);

    $response = $this->get(route('packages.show', $this->package->id))
                    ->assertOk()
                    ->assertJson(
                        $package->response()->getData(true)
                    );
});

test('Admin can update package', function() {
    $response = $this->actingAs($this->admin)
                    ->putJson(route('packages.update', $this->package->id), $this->updateData)
                    ->assertOk()
                    ->assertJson([
                        "data" => $this->updateData
                    ]);
});

test('A user cannot update package', function() {
    $response = $this->actingAs($this->user)
                    ->putJson(route('packages.update', $this->package->id), $this->updateData)
                    ->assertForbidden();
});

test('An unauthenticated user cannot update package', function() {
    $response = $this->putJson(route('packages.update', $this->package->id), $this->updateData)
                    ->assertUnauthorized();
});

test('Admin can delete a package', function(){
    $response = $this->actingAs($this->admin)
                    ->deleteJson(route('packages.destroy', $this->package->id))
                    ->assertNoContent();
});

test('A user cannot delete a package', function(){
    $response = $this->actingAs($this->user)
                    ->deleteJson(route('packages.destroy', $this->package->id))
                    ->assertForbidden();
});

test('An unauthenticated user cannot delete a package', function(){
    $response = $this->deleteJson(route('packages.destroy', $this->package->id))
                    ->assertUnauthorized();
});