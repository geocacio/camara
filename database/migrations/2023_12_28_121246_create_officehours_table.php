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
        Schema::create('officehours', function (Blueprint $table) {
            $table->id();
            $table->text('information')->nullable();
            $table->string('frequency')->nullable();
            $table->string('responsible_name')->nullable();
            $table->string('responsible_position')->nullable();
            $table->string('entity_name')->nullable();
            $table->string('entity_address')->nullable();
            $table->string('entity_zip_code')->nullable();
            $table->string('entity_cnpj')->nullable();
            $table->string('entity_email')->nullable();
            $table->string('entity_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officehours');
    }
};
