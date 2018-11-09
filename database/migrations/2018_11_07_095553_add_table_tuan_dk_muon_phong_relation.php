<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableTuanDkMuonPhongRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_tuan_muon_phong_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tuan_id')->unsigned();
            $table->integer('muon_phong_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('api_tuan_muon_phong_relation', function (Blueprint $table) {
            $table->foreign('tuan_id')->references('id')->on('api_tuan');
            $table->foreign('muon_phong_id')->references('id')->on('api_dang_ky_muon_phong');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_tuan_muon_phong_relation');
    }
}
