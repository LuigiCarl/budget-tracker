<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change status enum from ['active', 'inactive'] to ['active', 'blocked']
     */
    public function up(): void
    {
        // First, update any 'inactive' values to 'active' (since we're removing 'inactive')
        DB::table('users')->where('status', 'inactive')->update(['status' => 'active']);
        
        // Database-agnostic approach: drop and recreate the column
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'pgsql') {
            // PostgreSQL: Use ALTER TYPE or recreate
            // First check if type exists and add new value
            DB::statement("ALTER TABLE users ALTER COLUMN status TYPE VARCHAR(20)");
            DB::statement("ALTER TABLE users ALTER COLUMN status SET DEFAULT 'active'");
            // Add check constraint for PostgreSQL
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('active', 'blocked'))");
        } else {
            // MySQL: Use MODIFY COLUMN with ENUM
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'blocked') DEFAULT 'active'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert blocked users back to inactive
        DB::table('users')->where('status', 'blocked')->update(['status' => 'inactive']);
        
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'pgsql') {
            // PostgreSQL: Restore original constraint
            DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_status_check");
            DB::statement("ALTER TABLE users ADD CONSTRAINT users_status_check CHECK (status IN ('active', 'inactive'))");
        } else {
            // MySQL: Restore original enum
            DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive') DEFAULT 'active'");
        }
    }
};
