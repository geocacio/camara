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
        Schema::create('secretary_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diary_id');
            $table->unsignedBigInteger('secretary_id')->nullable();
            $table->unsignedBigInteger('summary_id');
            $table->integer('column')->default(1);
            $table->string('title');
            $table->longText('content');
            $table->string('slug');
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('summary_id')->references('id')->on('categories');
            $table->foreign('diary_id')->references('id')->on('official_journals');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretary_publications');
    }
};
