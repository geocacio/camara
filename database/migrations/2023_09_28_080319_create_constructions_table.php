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
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('local')->nullable();
            $table->date('expected_date')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constructions');
    }
};
