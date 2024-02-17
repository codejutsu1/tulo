<?php

use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\UtilityResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
   
    $this->user1 = Transaction::factory()->create();
    $this->user2 = Transaction::factory()->create(['package_id' => 20]);
});

test('admin can access the User Utility endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/utilities')
                    ->assertOk();
});

test('user can not access the User Utility endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/utilities')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the User Utility endpoint', function () {
    $response = $this->get('/api/v1/admin/users/'.$this->user1->user_id.'/utilities')
                    ->assertStatus(302);
});

test('User Utility returns all utilities associated to a user', function() {
    $utilities = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package.utility')
                        ->get()
                        ->pluck('package.utility')
                        ->unique()
                        ->values();

    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user1->user_id.'/utilities')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('User Utility does not return utilities associated to another user', function() {
    $utilities = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package.utility')
                        ->get()
                        ->pluck('package.utility')
                        ->unique()
                        ->values();

    $resource = UtilityResource::collection($utilities);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user2->user_id.'/utilities')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});