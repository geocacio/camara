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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->string('title');
            $table->integer('number');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('competency_id');
            $table->unsignedBigInteger('exercicy_id');
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->integer('views')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('group_id')->references('id')->on('categories');
            $table->foreign('competency_id')->references('id')->on('categories');
            $table->foreign('exercicy_id')->references('id')->on('categories');
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
