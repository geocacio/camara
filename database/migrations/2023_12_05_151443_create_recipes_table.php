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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('value')->nullable();
            $table->date('recipe_data')->nullable();
            $table->string('exercise')->nullable();
            $table->string('classification')->nullable();
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->string('organ')->nullable();
            $table->string('recipe_type')->nullable();
            $table->string('slip_number')->nullable();
            $table->string('object')->nullable();
            $table->string('history_information')->nullable();
            $table->string('text_button')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();

            $table->foreign('origin_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
