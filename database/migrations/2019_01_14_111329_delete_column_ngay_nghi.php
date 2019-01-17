<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnNgayNghi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_dang_ky_nghi', function ($table) {
            $table->dropColumn('ngay_nghi');

        });
        Schema::table('api_dang_ky_nghi', function ($table) {

            $table->dateTime('ngay_nghi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_dang_ky_nghi', function (Blueprint $table) {
            //
        });
    }
}
