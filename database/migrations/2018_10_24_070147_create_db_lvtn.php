<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbLvtn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_lich_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('phong_may_id')->unsigned();
            $table->integer('hk_id')->unsigned();
            $table->integer('thu_id')->unsigned();
            $table->integer('nhom_lop_id')->unsigned();
            $table->integer('mon_hoc_id')->unsigned();
            $table->text('tuan_hoc');
            $table->text('tuan_mon');
            $table->timestamps();
        });
        Schema::create('api_hoc_ky', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nam_hoc');
            $table->string('ngay_bat_dau');
            $table->string('ngay_ket_thuc');
            $table->timestamps();
        });
        Schema::create('api_thu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('api_nhom_lop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('si_so');
            $table->timestamps();
        });
        Schema::create('api_phong_may', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('api_phong_may_user_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phong_may_id')->unsigned();
            $table->integer('gv_id')->unsigned();
            $table->integer('ktv_id')->unsigned();
            $table->text('mota_gv');
            $table->text('mota_ktv');
            $table->timestamps();
        });
        Schema::create('api_mon_hoc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ma_mon_hoc');
            $table->string('name');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->timestamps();
        });
        Schema::create('api_ca', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phong_may_id')->unsigned();
            $table->integer('mon_hoc_id')->unsigned();
            $table->integer('ca_id')->unsigned();
            $table->integer('status');
            $table->timestamps();
        });
        Schema::create('api_dang_ky_nghi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('lich_day_id')->unsigned();
            $table->integer('description');
            $table->integer('status');
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
        Schema::dropIfExists('lich_day');
    }
}
