<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('formation_user', function (Blueprint $table) {
            $table->tinyInteger('status')
                  ->default(0)
                  ->after('user_id');    // 0=waiting,1=accepted,2=rejected,3=waiting-list
            $table->string('hash')
                  ->nullable()
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('formation_user', function (Blueprint $table) {
            $table->dropColumn(['status','hash']);
        });
    }
};
