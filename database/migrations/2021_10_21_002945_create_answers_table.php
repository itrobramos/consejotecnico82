<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('questionId')->unsigned();
            $table->bigInteger('schoolId')->unsigned();
            $table->bigInteger('gradeId')->unsigned();
            $table->bigInteger('formatId')->unsigned();

            $table->string('answer');
            $table->timestamps();

            $table->foreign('questionId')->references('id')->on('questions');
            $table->foreign('schoolId')->references('id')->on('schools');
            $table->foreign('gradeId')->references('id')->on('grades');
            $table->foreign('formatId')->references('id')->on('formats');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
