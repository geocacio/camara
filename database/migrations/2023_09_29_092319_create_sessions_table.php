<?php

use Dflydev\DotAccessData\Data;
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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('exercicy_id');
            $table->date('date');
            $table->text('description');
            $table->string('slug');
            $table->timestamps();
            $table->foreign('status_id')->references('id')->on('categories');
            $table->foreign('exercicy_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
