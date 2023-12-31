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
        if(Schema::hasColumn('pages', 'law_id')) return;
        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('law_id')->after('url')->nullable();
            $table->foreign('law_id')->references('id')->on('laws');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['law_id']);
            $table->dropColumn('law_id');
        });
    }
};
