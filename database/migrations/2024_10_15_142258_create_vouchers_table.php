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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_number')->unique();
            $table->date('voucher_date');
            $table->decimal('amount', 10, 2);          
            $table->string('supplier');  
            $table->string('nature');   
            $table->string('economic_category');
            $table->string('organization');
            $table->string('budget_unit');
            $table->string('project_activity');
            $table->string('function')->nullable();
            $table->string('sub_function')->nullable();
            $table->string('resource_source')->nullable();

            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
