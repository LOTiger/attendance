<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_ins', function (Blueprint $table) {
            $table->increments('id')->comment('签到id');
            $table->string('sign_in_token')->comment('签到事件唯一码');
            $table->integer('stu_id')->unsigned()->index()->comment('签到学生');
            $table->foreign('stu_id')->references('id')->on('students')->onDelete('cascade');
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
        Schema::dropIfExists('sign_ins');
    }
}
