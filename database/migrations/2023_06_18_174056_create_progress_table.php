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
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_id')->nullable();
            $table->string('title');
            $table->datetime('datetime');
            $table->text('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->foreign('bidding_id')->references('id')->on('biddings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
