<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class UserRel
{
    const ROLE = "role";
    const PROFILE = "profile";
}

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //belongsToMany la quan he n-n
    public function role()
    {
        return $this->belongsToMany('App\Models\Role', 'api_user_role_relation', 'user_id', 'role_id');
    }

    //hasOne la quan he 1-1
    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    }

    public function getUserQuery()
    {
        return $this->with(UserRel::ROLE)
            ->with(UserRel::PROFILE);
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
