<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools_formats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('schoolId')->unsigned();
            $table->bigInteger('formatId')->unsigned();
            $table->boolean('ended');
            $table->timestamps();


            $table->foreign('schoolId')->references('id')->on('schools');
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
        Schema::dropIfExists('schools_formats');
    }
}
