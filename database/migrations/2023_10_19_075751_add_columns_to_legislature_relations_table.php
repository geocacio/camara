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
        Schema::table('legislature_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('office_id')->nullable()->after('legislatureable_id');
            $table->unsignedBigInteger('bond_id');
            $table->date('first_period')->nullable()->after('office_id');
            $table->date('final_period')->nullable()->after('first_period');
            $table->foreign('office_id')->references('id')->on('offices');
            $table->foreign('bond_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legislature_relations', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
            $table->dropForeign(['bond_id']);
            $table->dropColumn('first_period');
            $table->dropColumn('final_period');
            $table->dropColumn('office_id');
            $table->dropColumn('bond_id');
        });
    }
};
