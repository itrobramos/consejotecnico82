<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_formats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('formatId')->unsigned();
            $table->bigInteger('schoolId')->unsigned();
            $table->bigInteger('userId')->unsigned();
            $table->timestamps();

            $table->foreign('schoolId')->references('id')->on('schools');
            $table->foreign('formatId')->references('id')->on('formats');
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sent_formats');
    }
}
