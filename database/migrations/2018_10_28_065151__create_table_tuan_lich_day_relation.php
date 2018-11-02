<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTuanLichDayRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_lich_day_tuan_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tuan_id')->unsigned();
            $table->integer('lich_day_id')->unsigned();
            $table->string('status');
            $table->timestamps();
            $table->foreign('tuan_id')->references('id')->on('api_tuan');
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
        //
    }
}
