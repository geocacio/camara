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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name');
            $table->string('plenary');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('cnpj');
            $table->string('cep');
            $table->string('address');
            $table->string('number')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('opening_hours')->nullable();
            $table->string('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
