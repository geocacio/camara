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
        Schema::table('secretaries', function (Blueprint $table) {
            $table->dropColumn('abbreviation');
            $table->string('plenary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secretaries', function (Blueprint $table) {
            $table->string('abbreviation')->nullable();
            $table->dropColumn('plenary');
        });
    }
};
