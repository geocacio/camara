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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('sphere');
            $table->date('validity');
            $table->string('bank_account')->nullable();
            $table->integer('instrument_number')->nullable();
            $table->date('celebration');
            $table->text('object');
            $table->decimal('counterpart', 10, 2);
            $table->decimal('transfer', 10, 2);
            $table->decimal('agreed', 10, 2);
            $table->string('grantor');
            $table->string('grantor_responsible');
            $table->string('convenent');
            $table->string('convenent_responsible');
            $table->text('justification')->nullable();
            $table->text('goals')->nullable();
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
