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
        Schema::create('sic_users', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('name');
            $table->date('birth');
            $table->enum('sex', ['male', 'female']);
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('schooling')->nullable();
            $table->string('password');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sic_users');
    }
};
