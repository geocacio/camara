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
        Schema::create('proceedings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->unsignedBigInteger('type_id');//category types with(ordem do dia);
            $table->timestamps();
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('type_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proceedings');
    }
};
