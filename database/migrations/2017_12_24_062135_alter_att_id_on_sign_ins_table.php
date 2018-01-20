<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAttIdOnSignInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('sign_in_token');
            $table->integer('att_id')->unsigned();
            $table->foreign('att_id')->references('id')->on('attendances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('att_id');
            $table->string('sign_in_token');
        });
    }
}
