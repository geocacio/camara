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
        if (Schema::hasColumn('lrfs', 'title')) return;
        Schema::table('lrfs', function (Blueprint $table) {
            $table->string('title')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lrfs', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
