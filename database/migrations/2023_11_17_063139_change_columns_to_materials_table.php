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
        Schema::table('materials', function (Blueprint $table) {
            // Remover a coluna session_id
            $table->dropForeign(['session_id']);
            $table->dropColumn('session_id');

            // Adicionar a coluna proceeding_id
            $table->unsignedBigInteger('proceeding_id')->after('councilor_id');
            $table->foreign('proceeding_id')->references('id')->on('proceedings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            // Reverter as alterações
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');

            $table->dropForeign(['proceeding_id']);
            $table->dropColumn('proceeding_id');
        });
    }
};
