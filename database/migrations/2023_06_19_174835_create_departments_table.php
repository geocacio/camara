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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id')->nullable();
            $table->unsignedBigInteger('organ_id')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->longText('description')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('organ_id')->references('id')->on('organs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
