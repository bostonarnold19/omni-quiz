<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTables extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('questionnaire_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('questionnaire_id')->nullable();
            $table->string('codes')->nullable();
            $table->string('retake')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->timestamps();
        });

        Schema::create('questionnaires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longtext('description')->nullable();
            $table->string('subject')->nullable();
            $table->string('course')->nullable();
            $table->string('time')->nullable();
            $table->string('is_published')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question')->nullable();
            $table->string('subject')->nullable();
            $table->string('course')->nullable();
            $table->timestamps();
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->string('is_correct')->nullable();
            $table->string('question_id')->nullable();
            $table->timestamps();
        });

        Schema::create('questionnaire_question', function (Blueprint $table) {
            $table->string('questionnaire_id')->nullable();
            $table->string('question_id')->nullable();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('questionnaire_code_id')->nullable();
            $table->string('question_id')->nullable();
            $table->string('question_option_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('user_questions');
    }
}
