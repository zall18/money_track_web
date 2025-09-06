<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goal>
 */
class GoalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
                $target = $this->faker->numberBetween(1000000, 10000000);
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement(['Laptop Baru', 'Liburan', 'Dana Darurat', 'HP']),
            'target_amount' => $target,
            'current_amount' => $this->faker->numberBetween(0, $target - 100000),
            'deadline' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
        ];
    }
}
