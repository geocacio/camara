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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('councilor_id');
            $table->unsignedBigInteger('session_id');
            $table->date('date');
            $table->date('start_period');
            $table->date('end_period');
            $table->string('status');
            $table->string('exercise');
            $table->text('description');
            $table->integer('views');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('councilor_id')->references('id')->on('councilors');
            $table->foreign('session_id')->references('id')->on('sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
