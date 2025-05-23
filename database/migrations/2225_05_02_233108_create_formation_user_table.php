<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')     ->constrained()->cascadeOnDelete();
            $table->boolean('etab_confirmed') ->default(false);
            $table->boolean('univ_confirmed')->default(false);
            $table->timestamps();

            $table->unique(['formation_id','user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_user');
    }
};
