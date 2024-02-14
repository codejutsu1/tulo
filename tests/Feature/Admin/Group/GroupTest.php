<?php

use App\Models\Group;
use App\Http\Resources\GroupResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
});

test('admin can access the Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                        ->get(route('group'))
                        ->assertOk();
});

test('unauthenticated users can not access the Group endpoint', function(){
    $response = $this->get(route('group'))
                        ->assertStatus(302);
});

test('authenticated users cannot access the Group endpoint', function(){
    $response = $this->actingAs($this->user)
                    ->get(route('group'))
                    ->assertForbidden();
});

test('Group endpoints returns JSON structure', function() {
    $response = $this->actingAs($this->admin)
                    ->get(route('group'))
                    ->assertJsonStructure([
                        'data' => [
                            '*' => [
                                'name'
                            ]
                        ]
                    ]);
});

test('Group endpoints returns group data', function() {
    $resource = GroupResource::collection(Group::all());

    $response = $this->actingAs($this->admin)
                    ->get(route('group'))
                    ->assertJson(
                        $resource->response()->getData(true)
                    );
});

