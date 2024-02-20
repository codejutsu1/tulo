<?php

use App\Models\Group;
use App\Http\Resources\UserResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
    createTransaction();
});

test('admin can access the Group User endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/groups/1/users')
                    ->assertOk();
});

test('user can not access the Group User endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/groups/1/users')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the Group User endpoint', function () {
    $response = $this->get('/api/v1/admin/groups/1/users')
                    ->assertFound();
});

test('Group User endpoint returns users associated with data group', function(){
    $users = Group::findOrFail(1)
                    ->utilities()
                    ->whereHas('packages.transactions')
                    ->with('packages.transactions.user')
                    ->get()
                    ->pluck('packages')
                    ->collapse()
                    ->pluck('transactions')
                    ->collapse()
                    ->pluck('user')
                    ->unique('id')
                    ->values();

    $resource  = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/1/users')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group User endpoint does not return users associated with other group', function(){
    $users = Group::findOrFail(3)
                    ->utilities()
                    ->whereHas('packages.transactions')
                    ->with('packages.transactions.user')
                    ->get()
                    ->pluck('packages')
                    ->collapse()
                    ->pluck('transactions')
                    ->collapse()
                    ->pluck('user')
                    ->unique('id')
                    ->values();

    $resource  = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/1/users')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});

test('Group User endpoint return users associated with cable group', function(){
    $users = Group::findOrFail(2)
                    ->utilities()
                    ->whereHas('packages.transactions')
                    ->with('packages.transactions.user')
                    ->get()
                    ->pluck('packages')
                    ->collapse()
                    ->pluck('transactions')
                    ->collapse()
                    ->pluck('user')
                    ->unique('id')
                    ->values();

    $resource  = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/2/users')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('Group User endpoint return users associated with utilities group', function(){
    $users = Group::findOrFail(3)
                    ->utilities()
                    ->whereHas('packages.transactions')
                    ->with('packages.transactions.user')
                    ->get()
                    ->pluck('packages')
                    ->collapse()
                    ->pluck('transactions')
                    ->collapse()
                    ->pluck('user')
                    ->unique('id')
                    ->values();

    $resource  = UserResource::collection($users);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/groups/3/users')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

