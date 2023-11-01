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
        Schema::create('construction_art', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('construction_id');
            $table->string('number');
            $table->string('responsible')->nullable();
            $table->date('date');
            $table->string('slug');
            $table->timestamps();

            // Chave estrangeira para o tipo de ART
            $table->foreign('construction_id')->references('id')->on('constructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_art');
    }
};
