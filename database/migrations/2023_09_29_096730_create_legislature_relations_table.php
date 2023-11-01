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
        Schema::create('legislature_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legislature_id');
            $table->morphs('legislatureable', 'legislatureable_index');
            $table->timestamps();
            $table->foreign('legislature_id')->references('id')->on('legislatures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislature_relations');
    }
};
