<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recurring_transaction>
 */
class RecurringTransactionFactory extends Factory
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
            'category_id' => Category::factory(),
            'amount' => $this->faker->numberBetween(10000, 1000000),
            'description' => $this->faker->sentence(),
            'frequency' => $this->faker->randomElement(['daily', 'weekly', 'monthly', 'yearly']),
            'start_date' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'end_date' => $this->faker->optional()->dateTimeBetween('now', '+6 months'),
        ];
    }
}
