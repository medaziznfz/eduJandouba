<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_grade', function (Blueprint $table) {
            $table->foreignId('formation_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('grade_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->primary(['formation_id','grade_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_grade');
    }
};
