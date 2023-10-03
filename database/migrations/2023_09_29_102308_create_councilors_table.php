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
        Schema::create('councilors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('bond_id');
            $table->date('start_bond')->nullable();
            // $table->date('end_mandate')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('biography')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('bond_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('councilors');
    }
};
