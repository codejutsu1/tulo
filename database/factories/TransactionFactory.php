<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_id' => mt_rand(1,5),
            'reference' => fake()->unique()->word(),
            'order_id' => fake()->unique()->word(),
            'status' => fake()->randomElement(['success', 'failure']),
            'message' => fake()->sentence(),
            'phone' => fake()->unique()->numerify('###########'),
            'network' => fake()->randomElement(['mtn', 'airtel', 'glo']),
            'amount' => fake()->randomNumber(4, true),
            'original_price' => fake()->randomNumber(4, true),
            'profit' => fake()->randomNumber(4, true),
        ];
    }
}
