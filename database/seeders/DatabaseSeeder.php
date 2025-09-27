<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo user
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create sample categories
        $incomeCategories = [
            ['name' => 'Salary', 'type' => 'income', 'color' => '#10b981'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#06b6d4'],
            ['name' => 'Investments', 'type' => 'income', 'color' => '#8b5cf6'],
        ];

        $expenseCategories = [
            ['name' => 'Food & Dining', 'type' => 'expense', 'color' => '#ef4444'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#f97316'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#eab308'],
            ['name' => 'Bills & Utilities', 'type' => 'expense', 'color' => '#6366f1'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#ec4899'],
        ];

        foreach ($incomeCategories as $categoryData) {
            $user->categories()->create($categoryData);
        }

        foreach ($expenseCategories as $categoryData) {
            $user->categories()->create($categoryData);
        }

        // Create sample accounts
        $user->accounts()->create([
            'name' => 'Main Checking',
            'type' => 'bank',
            'balance' => 2500.00,
            'description' => 'Primary checking account',
        ]);

        $user->accounts()->create([
            'name' => 'Savings',
            'type' => 'bank',
            'balance' => 10000.00,
            'description' => 'Emergency savings account',
        ]);

        $user->accounts()->create([
            'name' => 'Credit Card',
            'type' => 'credit_card',
            'balance' => 0.00,
            'description' => 'Main credit card',
        ]);
    }
}
