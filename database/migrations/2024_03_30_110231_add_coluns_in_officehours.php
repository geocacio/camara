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
        if(Schema::hasColumn('officehours', 'expedient')) return;
        Schema::table('officehours', function (Blueprint $table) {
            $table->longText('expedient')->nullable()->after('entity_phone');
            $table->string('site')->nullable()->after('expedient');
            $table->string('url_diario')->nullable()->after('site');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('officehours', function (Blueprint $table) {
            $table->dropColumn('expedient');
            $table->dropColumn('site');
            $table->dropColumn('url_diario');
        });
    }
};
