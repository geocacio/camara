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
        Schema::create('login_screens', function (Blueprint $table) {
            $table->id();
            $table->string('background')->nullable();
            $table->string('card_color')->nullable()->default('#fff');
            $table->string('button_color')->default('#0e6fc5');
            $table->string('button_hover')->default('#064c8b');
            $table->string('card_position')->default('center');
            $table->boolean('modal')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_screens');
    }
};
