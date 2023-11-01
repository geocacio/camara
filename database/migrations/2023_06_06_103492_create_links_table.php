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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('target_type')->nullable();
            $table->string('slug');
            $table->enum('visibility', ['enabled', 'disabled'])->default('enabled');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('type', ['link', 'button', 'dropdown']);
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->timestamps();

            $table->foreign('target_id')->references('id')->on('pages');
            $table->foreign('parent_id')->references('id')->on('links');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
