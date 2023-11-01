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
        Schema::create('transparency_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transparency_id');
            // $table->unsignedBigInteger('category_id');
            // $table->unsignedBigInteger('law_id');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('transparency_id')->references('id')->on('transparency_portals');
            // $table->foreign('category_id')->references('id')->on('categories');
            // $table->foreign('law_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_groups');
    }
};
