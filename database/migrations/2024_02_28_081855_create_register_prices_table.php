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
        Schema::create('register_prices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('signature_date');
            $table->string('expiry_date');
            $table->string('bidding_process');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('exercicio_id');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('exercicio_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_prices');
    }
};
