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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->string('situation');
            $table->string('model');
            $table->string('brand');
            $table->string('plate');
            $table->string('year');
            $table->enum('donation', ['sim', 'não']);
            $table->string('type');
            $table->text('purpose_vehicle');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('secretary_id')->references('id')->on('secretaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
