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
        Schema::create('publication_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_id')->nullable();
            $table->string('type');
            $table->string('description')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('publication_forms');
    }
};
