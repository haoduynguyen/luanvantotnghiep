<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
abstract class ThuRel
{
    //const demo = 'demo';
}
class Thu extends Model
{
    protected $table = "api_thu";

    protected $fillable = [
        'id',
        'name',
    ];
    public $timestamps = true;
}
