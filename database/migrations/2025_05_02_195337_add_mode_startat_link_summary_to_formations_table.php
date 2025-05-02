<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            // Résumé HTML
            $table->text('summary')->nullable()->after('description');

            // Mode : présentielle ou à distance
            $table->enum('mode', ['presentielle', 'a_distance'])
                  ->default('presentielle')
                  ->after('status');

            // Date & heure de début
            $table->dateTime('start_at')->nullable()->after('deadline');

            // Lien pour la session à distance
            $table->string('link')->nullable()->after('start_at');
        });
    }

    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn(['summary', 'mode', 'start_at', 'link']);
        });
    }
};
