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
        Schema::create('ordinances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('secretary_id');
            $table->unsignedBigInteger('office_id');
            $table->string('number');
            $table->date('date')->nullable();
            $table->string('agent')->nullable();
            $table->longText('detail')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordinances');
    }
};
