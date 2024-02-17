<?php

use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\PackageResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
   
    $this->user1 = Transaction::factory()->create();
    $this->user2 = Transaction::factory()->create();
});

test('admin can access the User Package endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/packages')
                    ->assertOk();
});

test('user can not access the User Package endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/packages')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the User Package endpoint', function () {
    $response = $this->get('/api/v1/admin/users/'.$this->user1->user_id.'/packages')
                    ->assertStatus(302);
});

test('User Package returns all packages associated to a user', function() {
    $packages = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package')
                        ->with('package')
                        ->get()
                        ->pluck('package');

    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user1->user_id.'/packages')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('User Package does not return packages associated to another user', function() {
    $packages = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package')
                        ->with('package')
                        ->get()
                        ->pluck('package');

    $resource = PackageResource::collection($packages);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user2->user_id.'/packages')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});