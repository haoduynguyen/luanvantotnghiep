<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPhongmayRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->integer('ca_id')->nullable()->unsigned();
            $table->integer('thu_id')->nullable()->unsigned();

        });
        Schema::table('api_phong_may_user_relation', function (Blueprint $table) {
            $table->foreign('ca_id')->references('id')->on('api_ca');
            $table->foreign('thu_id')->references('id')->on('api_thu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            //
        });
    }
}
