<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();

        User::factory(1000)->create(); //Set to 2000 later, The migration is slow on my local machine.

        $this->call([
            NetworkSeeder::class,
            DataSeeder::class
        ]);
    }
}
