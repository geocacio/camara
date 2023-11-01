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
        Schema::create('official_journal_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('official_journal_id');
            $table->unsignedBigInteger('publication_id');
            $table->timestamps();

            $table->foreign('official_journal_id')->references('id')->on('official_journals');
            $table->foreign('publication_id')->references('id')->on('secretary_publications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_journal_contents');
    }
};
