<?php

use App\Models\Utility;
use App\Http\Resources\PackageResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Utility Package endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/packages')
                    ->assertOk();
});

test('user can not access the Utility Package endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/utilities/1/packages')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Utility Package endpoint', function () {
    $response = $this->get('/api/v1/admin/utilities/1/packages')
                    ->assertStatus(302);
});

test('Utility endpoints returns the first packages', function() {
    $packages = Utility::findOrFail(1)->packages;

    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/1/packages')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Utility endpoints does not return packages associated with another utility', function() {
    $packages = Utility::findOrFail(1)->packages;

    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/utilities/2/packages')
                    ->assertJsonMissing(
                        $resource->response()->getData(true)
                    );
});