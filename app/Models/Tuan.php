<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuan extends Model
{
    protected $table = "api_tuan";

    protected $fillable = [
        'id',
        'name',
    ];
    public $timestamps = true;
}
