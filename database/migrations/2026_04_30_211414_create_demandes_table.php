<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('cin');
            $table->string('prenom');
            $table->string('nom');
            $table->string('email');
            $table->foreignId('etablissement_id')->constrained();
            $table->foreignId('grade_id')->constrained();
            $table->enum('status', ['request_processing', 'waiting_account_creation', 'account_created', 'account_declined'])->default('request_processing');
            $table->string('confirmation_token')->nullable()->unique();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
