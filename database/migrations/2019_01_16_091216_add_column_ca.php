<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_ca', function (Blueprint $table) {
            $table->time('gio_bat_dau')->nullable();
        });
        Schema::table('api_ca', function (Blueprint $table) {
            $table->time('gio_ket_thuc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_ca');
    }
}
