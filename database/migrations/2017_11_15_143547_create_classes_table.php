<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id')->comment('班级id');
            $table->integer('grade')->comment('年级');
            $table->integer('class_name')->comment('班名');
            $table->text('desc')->nullable()->comment('介绍');
            $table->integer('spe_id')->unsigned()->comment('所属专业id');
            $table->foreign('spe_id')->references('id')->on('specialities')->onDelete('cascade');
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
        Schema::dropIfExists('classes');
    }
}
