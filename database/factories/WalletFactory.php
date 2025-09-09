<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $walletNames = ['Cash Wallet', 'Bank BCA', 'Bank Mandiri', 'Gopay', 'OVO', 'Dana'];

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'name'    => $this->faker->unique()->randomElement($walletNames),
            'balance' => $this->faker->numberBetween(50000, 5000000),
        ];
    }
}
