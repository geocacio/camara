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
        Schema::table('secretary_publications', function (Blueprint $table) {
            $table->unsignedBigInteger('secretary_id')->nullable()->change();
            $table->unsignedBigInteger('summary_id')->nullable()->change();
            $table->unsignedBigInteger('diary_id')->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->longText('content')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secretary_publications', function (Blueprint $table) {
            $table->unsignedBigInteger('secretary_id')->nullable(false)->change();
            $table->unsignedBigInteger('summary_id')->nullable(false)->change();
            $table->unsignedBigInteger('diary_id')->nullable(false)->change();
            $table->string('title')->nullable(false)->change();
            $table->string('content')->nullable(false)->change();
        });
    }
};
