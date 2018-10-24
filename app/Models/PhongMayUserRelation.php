<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongMayUserRelation extends Model
{
    protected $table = "api_phong_may_user_relation";

    protected $fillable = [
        'id',
        'phong_may_id',
        'gv_id',
        'ktv_id',
        'mota_gv',
        'mota_ktv',
    ];
    public $timestamps = true;
}
