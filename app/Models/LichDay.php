<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichDay extends Model
{
    protected $table = "api_lich_day";

    protected $fillable = [
        'id',
        'user_id',
        'phong_may_id',
        'hk_id',
        'thu_id',
        'nhom_lop_id',
        'mon_hoc_id',
        'tuan_hoc',
        'tuan_mon',
        'ca_id',
    ];
    public $timestamps = true;
}
