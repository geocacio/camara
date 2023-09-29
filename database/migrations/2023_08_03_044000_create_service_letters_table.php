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
        Schema::create('service_letters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->json('service_letters')->nullable();
            $table->text('description')->nullable();
            $table->text('main_steps')->nullable();
            $table->text('requirements')->nullable();
            $table->text('completion_forecast')->nullable();
            $table->text('opening_hours')->nullable();
            $table->text('costs')->nullable();
            $table->text('service_delivery_methods')->nullable();
            $table->text('additional_information')->nullable();
            $table->integer('views')->nullable();
            $table->string('slug');

            $table->timestamps();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_letters');
    }
};
