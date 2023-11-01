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
        Schema::create('ombudsman_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ombudsman_survey_id');
            $table->unsignedBigInteger('ombudsman_question_id');
            $table->integer('note');
            $table->string('legend');
            $table->timestamps();

            $table->foreign('ombudsman_survey_id')->references('id')->on('ombudsman_surveys');
            $table->foreign('ombudsman_question_id')->references('id')->on('ombudsman_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ombudsman_responses');
    }
};
