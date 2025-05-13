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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('titre');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->string('duree');
            $table->string('lieu');

            // Capacity & scheduling
            $table->unsignedInteger('capacite');
            $table->unsignedInteger('sessions');
            $table->date('deadline');

            // Link back to your établissement (nullable)
            $table->foreignId('etablissement_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // New fields
            $table->enum('status', [
                'available',
                'in_progress',
                'completed',
                'canceled',
            ])->default('available');

            $table->unsignedInteger('nbre_demandeur')->default(0);
            $table->unsignedInteger('nbre_inscrit')   ->default(0);

            // New field to track accepted students
            $table->unsignedInteger('nbre_accepted')->default(0);  // Track accepted applicants

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
