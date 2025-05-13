<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the 'formation_user' table to add user_confirmed, status, and hash columns
        Schema::table('formation_user', function (Blueprint $table) {
            // Add 'user_confirmed' column to track if the user has confirmed the application
            $table->boolean('user_confirmed')->default(false)->after('univ_confirmed');
            
            // Add 'status' column to track the current status of the application
            // 0=waiting, 1=accepted, 2=rejected, 3=waiting-list, 4=confirmed
            $table->tinyInteger('status')->default(0)->after('user_confirmed');
            
            // Add 'hash' column to store a unique hash for user confirmation
            $table->string('hash')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        // Drop the 'user_confirmed', 'status', and 'hash' columns if the migration is rolled back
        Schema::table('formation_user', function (Blueprint $table) {
            $table->dropColumn(['user_confirmed', 'status', 'hash']);
        });
    }
};
