<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ca extends Model
{
    protected $table = "api_ca";

    protected $fillable = [
        'id',
        'name',
        'description',
        'gio_bat_dau',
        'gio_ket_thuc',
    ];
    public $timestamps = true;
}
