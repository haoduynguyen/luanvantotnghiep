<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDangKyMuonPhong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->integer('thu_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('hk_id')->unsigned();
        });
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('thu_id')->references('id')->on('api_thu');
            $table->foreign('hk_id')->references('id')->on('api_hoc_ky');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            //
        });
    }
}
