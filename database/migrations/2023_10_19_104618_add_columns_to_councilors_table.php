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
        Schema::table('councilors', function (Blueprint $table) {
            $table->unsignedBigInteger('party_affiliation_id')->nullable()->after('id');
            $table->date('affiliation_date')->nullable()->after('party_affiliation_id');
            $table->foreign('party_affiliation_id')->references('id')->on('party_affiliations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('councilors', function (Blueprint $table) {
            $table->dropForeign(['party_affiliation_id']);
            $table->dropColumn('affiliation_date');
            $table->dropColumn('party_affiliation_id');
        });
    }
};
