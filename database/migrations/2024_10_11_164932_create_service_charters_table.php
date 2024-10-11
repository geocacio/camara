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
        Schema::create('service_charters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->foreignId('category_id')->constrained('categories'); 
            $table->string('service_hours')->nullable();
            $table->string('service_completion_time')->nullable();
            $table->decimal('user_cost', 8, 2)->nullable();
            $table->string('service_provision_methods')->nullable();
            $table->text('service_steps')->nullable();
            $table->text('requirements_documents')->nullable();
            $table->string('links')->nullable()->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_charters');
    }
};
