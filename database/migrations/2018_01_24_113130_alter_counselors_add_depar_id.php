<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCounselorsAddDeparId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counselors', function (Blueprint $table) {
            $table->integer('depar_id')->unsigned()->index()->default(1);
            $table->foreign('depar_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counselors', function (Blueprint $table) {
            $table->dropForeign('counselors_depar_id_foreign');
            $table->dropColumn('depar_id');
        });
    }
}
