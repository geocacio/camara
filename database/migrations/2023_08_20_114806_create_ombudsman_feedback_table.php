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
        Schema::create('ombudsman_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('protocol')->uniqid();
            $table->enum('anonymous', ['sim', 'não']);
            $table->string('name')->nullable();
            $table->string('cpf')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('sex')->nullable();
            $table->string('level_education')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_type')->nullable();
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->string('nature');
            $table->longText('message');
            $table->longText('answer')->nullable();
            $table->date('deadline');
            $table->date('new_deadline')->nullable();
            $table->enum('status', ['Aguardando resposta', 'Finalizado'])->default('Aguardando resposta');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ombudsman_feedback');
    }
};
