<?php

use App\Models\Package;
use App\Http\Resources\UtilityResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});


test('admin can access the Package Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/packages/1/utilities')
                    ->assertOk();
});

test('user can not access the Package Utility endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/packages/1/utilities')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Package Utility endpoint', function () {
    $response = $this->get('/api/v1/admin/packages/1/utilities')
                    ->assertFound();
});

test('Package Utility Endpoint returns utilities associated to a package', function() {
    $utility = Package::findOrFail(1)->utility;

    $resource = new UtilityResource($utility);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/packages/1/utilities')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Package Utility Endpoint does not return utilities associated to another package', function() {
    $utility = Package::findOrFail(1)->utility;

    $resource = new UtilityResource($utility);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/packages/20/utilities')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});