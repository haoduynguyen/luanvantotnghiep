<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserProfile extends Model
{
    protected $table ="api_user_profile";
    use SoftDeletes;
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'user_id',
        'ma_nhan_vien',
    ];
    protected $dates = ['deleted_at'];
    public $timestamps = true;
}
