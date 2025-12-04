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
        // For MySQL, we need to modify the enum values
        // First, update any 'inactive' values to 'active' (since we're removing 'inactive')
        DB::table('users')->where('status', 'inactive')->update(['status' => 'active']);
        
        // Now modify the enum to use 'active' and 'blocked'
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'blocked') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert blocked users back to inactive
        DB::table('users')->where('status', 'blocked')->update(['status' => 'inactive']);
        
        // Restore original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive') DEFAULT 'active'");
    }
};
