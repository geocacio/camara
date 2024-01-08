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
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('secretary_id')->after('status')->nullable();
            $table->string('contact_number')->after('status')->nullable();
            $table->string('credor')->after('status')->nullable();
            $table->foreign('secretary_id')->references('id')->on('secretaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_secretary_id_foreign');
            $table->dropColumn('secretary_id');
        });
    }
};
