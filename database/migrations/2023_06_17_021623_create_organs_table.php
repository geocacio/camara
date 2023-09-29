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
        Schema::create('organs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->string('name');
            $table->string('cnpj');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('email')->nullable();
            $table->string('business_hours')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('status')->nullable();
            $table->longText('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            // Responsável: o funcionário responsável pelo órgão.
            // Tipo de órgão: uma classificação ou categoria para o órgão, por exemplo, executivo, legislativo, judiciário, etc.
            // Setor: uma divisão ou setor específico dentro do órgão.
            // Orçamento: informações relacionadas ao orçamento do órgão.
            // Hierarquia: informações sobre a posição hierárquica do órgão dentro da estrutura da secretaria.


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organs');
    }
};
