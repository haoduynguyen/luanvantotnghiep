<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table ="api_user_profile";
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'gender',
        'phone',
        'user_id',
    ];
}
