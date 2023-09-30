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
        Schema::create('executive_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('councilor_id');
            $table->string('office');
            $table->timestamps();

            $table->foreign('councilor_id')->references('id')->on('councilors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_boards');
    }
};
