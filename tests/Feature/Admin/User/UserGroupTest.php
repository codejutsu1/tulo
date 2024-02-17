<?php

use App\Models\User;
use App\Models\Transaction;
use App\Http\Resources\GroupResource;

beforeEach(function() {
    $this->user = createUser();
    $this->admin = createUser(isAdmin: 1);
   
    $this->user1 = Transaction::factory()->create();
    $this->user2 = Transaction::factory()->create(['package_id' => 20]);
});

test('admin can access the User Group endpoint', function () {
    $response = $this->actingAs($this->admin)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/groups')
                    ->assertOk();
});

test('user can not access the User Group endpoint', function () {
    $response = $this->actingAs($this->user)
                    ->get('/api/v1/admin/users/'.$this->user1->user_id.'/groups')
                    ->assertForbidden();
});

test('Unauthenticated user can not access the User Group endpoint', function () {
    $response = $this->get('/api/v1/admin/users/'.$this->user1->user_id.'/groups')
                    ->assertStatus(302);
});

test('User Group returns all groups associated to a user', function() {
    $groups = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package')
                        ->with('package.utility.group') 
                        ->get()
                        ->pluck('package.utility.group')
                        ->unique()
                        ->values();

    $resource = GroupResource::collection($groups);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user1->user_id.'/groups')
                        ->assertJson(
                            $resource->response()->getData(true)
                        );
});

test('User Group does not return groups associated to another user', function() {
    $groups = User::findOrFail($this->user1->user_id)
                        ->transactions()
                        ->whereHas('package')
                        ->with('package.utility.group') 
                        ->get()
                        ->pluck('package.utility.group')
                        ->unique()
                        ->values();

    $resource = GroupResource::collection($groups);

    $response = $this->actingAs($this->admin)
                        ->get('/api/v1/admin/users/'.$this->user2->user_id.'/groups')
                        ->assertJsonMissing(
                            $resource->response()->getData(true)
                        );
});