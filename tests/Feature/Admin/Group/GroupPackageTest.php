<?php

use App\Models\Group;
use App\Http\Resources\PackageResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group Package endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/packages')
                    ->assertOk();
});

test('user can not access the Group Package endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/packages')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group Package endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/packages')
                    ->assertFound();
});

test('Group package endpoint returns data packages', function(){
    $packages = Group::findOrFail(1)
                        ->utilities()
                        ->whereHas('packages')
                        ->with('packages')
                        ->get()
                        ->pluck('packages')
                        ->collapse();
    
    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/1/packages')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group package endpoint returns cable packages', function(){
    $packages = Group::findOrFail(2)
                        ->utilities()
                        ->whereHas('packages')
                        ->with('packages')
                        ->get()
                        ->pluck('packages')
                        ->collapse();
    
    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/2/packages')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group package endpoint returns utilities packages', function(){
    $packages = Group::findOrFail(3)
                        ->utilities()
                        ->whereHas('packages')
                        ->with('packages')
                        ->get()
                        ->pluck('packages')
                        ->collapse();
    
    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/3/packages')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});
