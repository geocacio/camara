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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('office_id')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cpf')->nullable();
            $table->integer('dependents')->default(0)->nullable();
            $table->date('admission_date')->nullable();
            $table->enum('employment_type', ['Permanent', 'Temporary', 'Contractor', 'Intern'])->nullable();
            $table->enum('status', ['Active','Inactive','Suspended','On Leave','Terminated','Retired','Transferred','In Training','Hiring Process']);
            $table->string('slug')->nullable();
            $table->timestamps();
            $table->foreign('office_id')->references('id')->on('offices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
