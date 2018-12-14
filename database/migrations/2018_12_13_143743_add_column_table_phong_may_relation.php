<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTablePhongMayRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->integer('tuan_id')->nullable()->unsigned();
        });
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
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
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            //
        });
    }
}
