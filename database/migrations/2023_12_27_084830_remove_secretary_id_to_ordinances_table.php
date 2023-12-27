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
        if (!Schema::hasColumn('ordinances', 'secretary_id')) return;
        Schema::table('ordinances', function (Blueprint $table) {
            $table->dropForeign(['secretary_id']);
            $table->dropColumn('secretary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordinances', function (Blueprint $table) {
            $table->unsignedBigInteger('secretary_id');
            $table->foreign('secretary_id')->references('id')->on('secretaries');
        });
    }
};
