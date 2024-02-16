<?php

use App\Models\Group;
use App\Http\Resources\UtilityResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/utilities')
                    ->assertOk();
});

test('user can not access the Group Utility endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/utilities')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group Utility endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/utilities')
                    ->assertStatus(302);
});

test('Group utilities endpoint returns data utilites', function() {
    $utilities = Group::findOrFail(1)->utilities;
    
    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/utilities')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Group utilities endpoint returns cable utilites', function() {
    $utilities = Group::findOrFail(2)->utilities;
    
    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/2/utilities')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

test('Group utilities endpoint returns utilities utilites', function() {
    $utilities = Group::findOrFail(3)->utilities;
    
    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/3/utilities')
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});