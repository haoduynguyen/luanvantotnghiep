<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationDbLvtn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_lich_day', function (Blueprint $table) {
            $table->integer('ca_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('phong_may_id')->references('id')->on('api_phong_may');
            $table->foreign('hk_id')->references('id')->on('api_hoc_ky');
            $table->foreign('thu_id')->references('id')->on('api_thu');
            $table->foreign('nhom_lop_id')->references('id')->on('api_nhom_lop');
            $table->foreign('mon_hoc_id')->references('id')->on('api_mon_hoc');
            $table->foreign('ca_id')->references('id')->on('api_ca');
        });
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->foreign('gv_id')->references('id')->on('users');
            $table->foreign('phong_may_id')->references('id')->on('api_phong_may');
            $table->foreign('ktv_id')->references('id')->on('users');
        });
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->foreign('phong_may_id')->references('id')->on('api_phong_may');
            $table->foreign('mon_hoc_id')->references('id')->on('api_mon_hoc');
            $table->foreign('ca_id')->references('id')->on('api_ca');
        });
        Schema::table('api_dang_ky_nghi', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lich_day_id')->references('id')->on('api_lich_day');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('relation');
    }
}
