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
        Schema::table('lais', function (Blueprint $table) {
            $table->string('state_lai');
            $table->string('federal_lai');
            $table->dropColumn('slug');
            $table->dropColumn('title');
            $table->dropColumn('icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lais', function (Blueprint $table) {
            $table->dropColumn('state_lai');
            $table->dropColumn('federal_lai');
            $table->string('slug');
            $table->string('title');
            $table->string('icon');
        });
    }
};
