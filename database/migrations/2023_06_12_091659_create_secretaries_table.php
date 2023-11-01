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
        Schema::create('secretaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->string('cnpj');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secretaries');
    }
};
