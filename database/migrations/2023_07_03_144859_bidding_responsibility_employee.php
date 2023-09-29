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
        Schema::create('bidding_responsibility_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_id');
            $table->unsignedBigInteger('responsibility_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();

            $table->foreign('bidding_id')->references('id')->on('biddings');
            $table->foreign('responsibility_id')->references('id')->on('categories');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidding_responsibility_employee');
    }
};
