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
        Schema::create('selective_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercicy_id');
            $table->string('description');
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->integer('views')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            
            $table->foreign('exercicy_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selective_processes');
    }
};
