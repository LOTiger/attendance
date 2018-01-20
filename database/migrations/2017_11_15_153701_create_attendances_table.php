<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('id')->comment('签到事件id');
            $table->string('att_token')->comment('签到事件唯一码');
            $table->integer('should')->comment('签到事件应到人数');
            $table->integer('real')->default(0)->comment('签到事件实到人数');
            $table->integer('class_id')->unsigned()->comment('签到班级id');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');
            $table->integer('creator_id')->unsigned()->comment('签到事件发起者id');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('attendances');
    }
}
