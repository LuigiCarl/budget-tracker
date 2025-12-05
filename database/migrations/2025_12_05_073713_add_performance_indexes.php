<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add composite indexes for frequently used query patterns
     */
    public function up(): void
    {
        // Transactions table - most queried table
        Schema::table('transactions', function (Blueprint $table) {
            // For queries filtering by user + date range + type
            $table->index(['user_id', 'date', 'type'], 'idx_transactions_user_date_type');
            // For queries filtering by account + date
            $table->index(['account_id', 'date'], 'idx_transactions_account_date');
            // For queries filtering by category
            $table->index(['user_id', 'category_id', 'type'], 'idx_transactions_user_category_type');
        });

        // Accounts table
        Schema::table('accounts', function (Blueprint $table) {
            // For queries filtering by user + created_at
            $table->index(['user_id', 'created_at'], 'idx_accounts_user_created');
        });

        // Budgets table
        Schema::table('budgets', function (Blueprint $table) {
            // For queries filtering by user + category + date range
            $table->index(['user_id', 'category_id', 'start_date', 'end_date'], 'idx_budgets_user_category_dates');
        });

        // Categories table
        Schema::table('categories', function (Blueprint $table) {
            // For queries filtering by user + type
            $table->index(['user_id', 'type'], 'idx_categories_user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_user_date_type');
            $table->dropIndex('idx_transactions_account_date');
            $table->dropIndex('idx_transactions_user_category_type');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropIndex('idx_accounts_user_created');
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropIndex('idx_budgets_user_category_dates');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_user_type');
        });
    }
};
