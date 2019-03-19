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
        Schema::create('group_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('is_published')->nullable();
            $table->longtext('description')->nullable();
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question')->nullable();
            $table->string('type')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });

        Schema::create('group_question_question', function (Blueprint $table) {
            $table->string('group_question_id')->nullable();
            $table->string('question_id')->nullable();
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->string('is_correct')->nullable();
            $table->string('question_id')->nullable();
            $table->timestamps();
        });

        Schema::create('user_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->nullable();
            $table->string('group_question_id')->nullable();
            $table->string('question_id')->nullable();
            $table->string('question_option_id')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('group_question');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('user_questions');
    }
}
