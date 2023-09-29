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
        Schema::create('secretary_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->morphs('secretaryable');
            $table->timestamps();

            $table->foreign('secretary_id')->references('id')->on('secretaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretary_contents');
    }
};
