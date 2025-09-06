<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Flowcash;
use App\Models\Goal;
use App\Models\RecurringTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

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
        // Buat 1 user utama
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Buat kategori income
        $incomeCategories = collect([
            'Gaji',
            'Freelance',
            'Investasi',
            'Hadiah',
        ])->map(fn($name) =>
            Category::create([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'income',
            ])
        );

        // Buat kategori expense
        $expenseCategories = collect([
            'Makan',
            'Transportasi',
            'Belanja',
            'Hiburan',
            'Tagihan',
        ])->map(fn($name) =>
            Category::create([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'expense',
            ])
        );

        // Gabungkan semua kategori
        $allCategories = $incomeCategories->merge($expenseCategories);

        // Buat transaksi (Flowcash) - 30 record
        Flowcash::factory(30)->create([
            'user_id' => $user->id,
        ])->each(function ($transaction) use ($allCategories) {
            $transaction->category_id = $allCategories->random()->id;
            $transaction->save();
        });

        // Buat budgets untuk beberapa kategori expense
        foreach ($expenseCategories->random(2) as $category) {
            Budget::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'amount' => fake()->numberBetween(500000, 2000000),
                'period' => now()->startOfMonth(),
            ]);
        }

        // Buat goals (saving plans)
        Goal::create([
            'user_id' => $user->id,
            'name' => 'Beli Laptop',
            'target_amount' => 10000000,
            'current_amount' => 2500000,
            'deadline' => now()->addMonths(6),
        ]);

        Goal::create([
            'user_id' => $user->id,
            'name' => 'Dana Darurat',
            'target_amount' => 5000000,
            'current_amount' => 1000000,
            'deadline' => now()->addYear(),
        ]);

        // Buat recurring transactions (contoh tagihan bulanan)
        RecurringTransaction::create([
            'user_id' => $user->id,
            'category_id' => $expenseCategories->firstWhere('name', 'Tagihan')->id,
            'amount' => 300000,
            'description' => 'Langganan Internet',
            'frequency' => 'monthly',
            'start_date' => now()->subMonths(2),
            'end_date' => null,
        ]);

        RecurringTransaction::create([
            'user_id' => $user->id,
            'category_id' => $expenseCategories->firstWhere('name', 'Transportasi')->id,
            'amount' => 500000,
            'description' => 'Transportasi Harian',
            'frequency' => 'monthly',
            'start_date' => now()->subMonths(1),
            'end_date' => null,
        ]);
    }
}
