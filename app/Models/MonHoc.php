<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $table = "api_mon_hoc";

    protected $fillable = [
        'id',
        'ma_mon_hoc',
        'name',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];
    public $timestamps = true;
}
