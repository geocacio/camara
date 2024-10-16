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
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('voucher_id')->constrained('vouchers')->nullable()->after('creditor_number');
            $table->string('payment_number')->after('voucher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);

            $table->dropColumn('voucher_id');
            $table->dropColumn('payment_number');
        });
    }
};
