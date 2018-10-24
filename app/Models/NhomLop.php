<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhomLop extends Model
{
    protected $table = "api_nhom_lop";

    protected $fillable = [
        'id',
        'name',
        'si_so',
    ];
    public $timestamps = true;
}
