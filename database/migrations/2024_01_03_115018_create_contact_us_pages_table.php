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
        Schema::create('contact_us_pages', function (Blueprint $table) {
            $table->id();
            $table->string('telefone');
            $table->text('opening_hours')->nullable();
            $table->string('email', 100);
            // status: 0 - disabled, 1 - enabled
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us_pages');
    }
};
