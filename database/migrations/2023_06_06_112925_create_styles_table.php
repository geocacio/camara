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
        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->morphs('styleable');
            $table->string('name')->nullable();
            $table->string('type_style')->nullable();
            $table->string('classes');
            $table->string('background_color')->nullable();
            $table->string('background_color_night')->nullable();
            $table->string('title_color')->nullable();
            $table->string('title_color_night')->nullable();
            $table->string('title_size')->nullable();
            $table->string('subtitle_color')->nullable();
            $table->string('subtitle_color_night')->nullable();
            $table->string('subtitle_size')->nullable();
            $table->string('description_color')->nullable();
            $table->string('description_color_night')->nullable();
            $table->string('description_size')->nullable();
            $table->string('button_text_color')->nullable();
            $table->string('button_text_color_night')->nullable();
            $table->string('button_text_size')->nullable();
            $table->string('button_background_color')->nullable();
            $table->string('button_background_color_night')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('styles');
    }
};
