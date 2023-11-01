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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercicy_id');
            $table->unsignedBigInteger('competency_id');
            $table->unsignedBigInteger('type_leaf_id');
            $table->decimal('earnings', 10, 2)->nullable();
            $table->enum('calculate_earnings', ['yes', 'no'])->default('no');
            $table->decimal('deductions', 10, 2)->nullable();
            $table->enum('calculate_deductions', ['yes', 'no'])->default('no');
            $table->decimal('net_pay', 10, 2)->nullable();
            $table->enum('calculate_net_pay', ['yes', 'no'])->default('no');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->foreign('exercicy_id')->references('id')->on('categories');
            $table->foreign('competency_id')->references('id')->on('categories');
            $table->foreign('type_leaf_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
