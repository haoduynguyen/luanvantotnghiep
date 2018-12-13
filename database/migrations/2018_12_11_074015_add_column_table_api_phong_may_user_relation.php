<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableApiPhongMayUserRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->integer('mon_hoc_id')->nullable()->unsigned();
        });
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->foreign('mon_hoc_id')->references('id')->on('api_mon_hoc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            //
        });
    }
}
