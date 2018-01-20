<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterInLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->renameColumn('lesson_name','name');
            $table->dropColumn('teacher_work_num');
            $table->integer('teacher_id')->nullable();
            $table->boolean('is_single');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->renameColumn('name','lesson_name');
            $table->dropColumn('teacher_id');
            $table->integer('teacher_work_num')->nullable();
            $table->dropColumn('is_single');
        });
    }
}
