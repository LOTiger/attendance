<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id')->comment('课程id');
            $table->string('lesson_name')->comment('课程名称');
            $table->integer('section')->comment('节次');
            $table->integer('week_begin')->comment('起始周');
            $table->integer('week_end')->comment('结束周');
            $table->integer('weekday')->comment('周几');
            $table->integer('room_id')->unsigned()->comment('课室id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->integer('class_id')->unsigned()->comment('班级id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
