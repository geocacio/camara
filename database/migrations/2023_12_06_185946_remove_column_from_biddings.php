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
        Schema::table('biddings', function (Blueprint $table) {
            $table->dropForeign(['secretary_id']);
            $table->dropColumn('secretary_id');

            $table->dropForeign(['organ_id']);
            $table->dropColumn('organ_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biddings', function (Blueprint $table) {
            //
        });
    }
};
