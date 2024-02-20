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
        if(Schema::hasColumn('files', 'format')) return;
        Schema::table('files', function (Blueprint $table) {
            $table->string('format')->nullable()->after('url');
            $table->bigInteger('size')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('format');
            $table->dropColumn('size');
        });
    }
};
