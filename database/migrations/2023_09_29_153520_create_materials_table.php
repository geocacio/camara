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
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('type_id');
            $table->date('date');
            $table->text('description')->nullable();
            $table->integer('views')->nullable();
            $table->string('slug');
            $table->timestamps();

            $table->foreign('councilor_id')->references('id')->on('councilors');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('status_id')->references('id')->on('categories');
            $table->foreign('type_id')->references('id')->on('types');
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
