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
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->unsignedBigInteger('organ_id')->nullable();
            $table->string('number');
            $table->date('opening_date')->nullable();
            $table->string('status')->nullable();
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('slug')->nullable();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('organ_id')->references('id')->on('organs');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biddings');
    }
};
