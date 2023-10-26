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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('councilor_id');
            // $table->string('name');
            // $table->string('position');
            // $table->string('party');
            $table->string('authorship')->nullable();
            // $table->string('slug');
            $table->timestamps();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('councilor_id')->references('id')->on('councilors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
