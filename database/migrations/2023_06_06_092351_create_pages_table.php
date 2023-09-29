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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route')->nullable();
            $table->string('main_title')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_title')->nullable();
            $table->longText('featured_description')->nullable();
            $table->string('icon')->nullable();
            $table->string('slug')->nullable();
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
