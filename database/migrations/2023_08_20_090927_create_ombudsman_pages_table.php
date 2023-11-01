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
        Schema::create('ombudsman_pages', function (Blueprint $table) {
            $table->id();
            $table->string('main_title')->nullable();
            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('route')->nullable();
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ombudsman_pages');
    }
};
