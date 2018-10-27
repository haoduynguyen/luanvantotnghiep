<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTablePhongMay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_phong_may', function (Blueprint $table) {
            $table->text('mo_ta')->nullable();
            $table->integer('so_may');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_phong_may', function (Blueprint $table) {
            //
        });
    }
}
