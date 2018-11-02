<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichDayTuanRelation extends Model
{
    protected $table = "api_lich_day_tuan_relation";

    protected $fillable = [
        'id',
        'tuan_id',
        'lich_day_id',
        'status',
    ];
    public $timestamps = true;
}
