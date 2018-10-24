<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HocKy extends Model
{
    protected $table = "api_hoc_ky";

    protected $fillable = [
        'id',
        'name',
        'nam_hoc',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];
    public $timestamps = true;
}
