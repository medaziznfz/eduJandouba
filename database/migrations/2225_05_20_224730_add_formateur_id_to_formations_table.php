<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            // Add the formateur_id column (must match users.id type)
            $table->unsignedBigInteger('formateur_id')
                  ->nullable()
                  ->after('etablissement_id');

            // Set up the foreign key constraint
            $table->foreign('formateur_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['formateur_id']);
            // Then drop the column
            $table->dropColumn('formateur_id');
        });
    }
};
