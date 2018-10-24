<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DangKyNghi extends Model
{
    protected $table = "api_dang_ky_nghi";

    protected $fillable = [
        'id',
        'user_id',
        'lich_day_id',
        'description',
        'status',
    ];
    public $timestamps = true;
}
