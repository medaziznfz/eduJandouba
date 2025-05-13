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
        Schema::table('formations', function (Blueprint $table) {
            $table->string('formateur_name')->nullable(); // Formateur's name
            $table->string('formateur_email')->nullable(); // Formateur's email
        });
    }

    public function down()
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropColumn(['formateur_name', 'formateur_email']);
        });
    }


};
