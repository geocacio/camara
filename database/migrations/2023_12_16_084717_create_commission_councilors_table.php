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
        Schema::create('commission_councilors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_id');
            $table->unsignedBigInteger('councilor_id');
            $table->unsignedBigInteger('legislature_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreign('commission_id')->references('id')->on('commissions');
            $table->foreign('councilor_id')->references('id')->on('councilors');
            $table->foreign('legislature_id')->references('id')->on('legislatures');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_councilors');
    }
};
