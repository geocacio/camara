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
        Schema::create('agreement_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agreement_id');
            $table->date('date_proponent')->nullable();
            $table->decimal('value_proponent', 10,2)->nullable();
            $table->date('date_concedent')->nullable();
            $table->decimal('value_concedent', 10,2)->nullable();
            $table->timestamps();

            $table->foreign('agreement_id')->references('id')->on('agreements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreement_transfers');
    }
};
