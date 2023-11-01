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
        Schema::create('construction_measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('construction_id');
            $table->string('responsible_execution');
            $table->string('responsible_supervision');
            $table->string('folder_manager');
            $table->date('first_date');
            $table->date('end_date');
            $table->string('situation');
            $table->integer('invoice');
            $table->date('invoice_date');
            $table->decimal('price', 10, 2);
            $table->string('slug');
            $table->timestamps();
            $table->foreign('construction_id')->references('id')->on('constructions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_measurements');
    }
};
