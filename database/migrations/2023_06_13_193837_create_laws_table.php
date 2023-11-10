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
        Schema::create('laws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competency_id');
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            
            $table->foreign('competency_id')->references('id')->on('categories');
            $table->foreign('exercicy_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws');
    }
};
