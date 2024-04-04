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
        if(Schema::hasColumn('configure_official_diaries', 'normatives')) return;
        Schema::table('configure_official_diaries', function (Blueprint $table) {
            $table->longText('normatives')->nullable()->after('footer_text');
            $table->longText('presentation')->nullable()->after('footer_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configure_official_diaries', function (Blueprint $table) {
            $table->dropColumn('normatives');
            $table->dropColumn('presentation');
        });
    }
};
