<?php

use App\Models\User;
use App\Models\Transaction;
use Database\Seeders\RoleSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\UtilitySeeder;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->beforeEach(fn() => 
    $this->seed(RoleSeeder::class, 
    $this->seed(GroupSeeder::class),
    $this->seed(UtilitySeeder::class),
    $this->seed(PackageSeeder::class),
))
->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createUser(int $isAdmin = 3)
{
    return User::factory()->create([
        'role_id' => $isAdmin,
    ]);
}

function createTransaction()
{
    collect(range(1, 22))->map(function($data) {
        return Transaction::factory()->create(['package_id' => $data]);
    });
}