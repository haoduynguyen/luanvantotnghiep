<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongMay extends Model
{
    protected $table = "api_phong_may";

    protected $fillable = [
        'id',
        'name',
    ];
    public $timestamps = true;
}
