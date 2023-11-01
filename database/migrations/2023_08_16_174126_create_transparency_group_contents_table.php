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
        Schema::create('transparency_group_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transparency_group_id');
            $table->morphs('pageable');
            $table->timestamps();
            $table->foreign('transparency_group_id')->references('id')->on('transparency_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparency_group_contents');
    }
};
