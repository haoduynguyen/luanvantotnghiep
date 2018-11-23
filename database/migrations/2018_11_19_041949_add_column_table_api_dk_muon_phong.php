<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTableApiDkMuonPhong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->integer('tuan_id')->unsigned()->nullable();
        });
        Schema::table('api_dang_ky_muon_phong', function (Blueprint $table) {
            $table->foreign('tuan_id')->references('id')->on('api_tuan');
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
