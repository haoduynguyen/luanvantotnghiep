<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class RoleRel
{
    const USER = 'user';
}

class Role extends Model
{
    protected $table = "api_role";

    protected $fillable = [
        'id',
        'name',
    ];
    public $timestamps = true;

    public function users()
    {
        $this->belongsToMany('App/User','api_user_role','role_id','user_id');
    }

    public function getRoleQuery()
    {
        $this->with(RoleRel::USER);
    }
}
