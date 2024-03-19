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
        if(Schema::hasColumn('register_prices', 'object')) return;
        Schema::table('register_prices', function (Blueprint $table) {
            $table->string('object')->after('bidding_process');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_prices', function (Blueprint $table) {
            //
        });
    }
};
