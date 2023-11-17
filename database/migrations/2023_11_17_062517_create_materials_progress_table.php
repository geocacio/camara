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
        Schema::create('materials_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('proceeding_id');
            $table->string('phase');
            $table->text('observations')->nullable();
            $table->timestamps();

            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('proceeding_id')->references('id')->on('proceedings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_progress');
    }
};
