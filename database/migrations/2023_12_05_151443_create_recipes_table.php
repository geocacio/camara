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
            $table->string('value');
            $table->date('recipe_data');
            $table->string('exercise');
            $table->string('classification');
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->string('organ');
            $table->string('recipe_type');
            $table->string('slip_number');
            $table->string('object');
            $table->string('history_information')->nullable();
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
