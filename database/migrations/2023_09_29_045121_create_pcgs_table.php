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
        Schema::create('pcgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exercicy_id');
            $table->date('date')->nullable();
            $table->string('audit_court_situation')->nullable();
            $table->string('court_accounts_date')->nullable();
            $table->string('legislative_judgment_situation')->nullable();
            $table->string('legislative_judgment_date')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->foreign('exercicy_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pcgs');
    }
};
