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
        Schema::create('councilors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('current_position')->nullable();
            $table->string('current_bond')->nullable();
            $table->date('start_mandate')->nullable();
            $table->date('end_mandate')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('biography')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('councilors');
    }
};
