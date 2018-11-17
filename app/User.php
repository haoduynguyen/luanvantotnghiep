<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class UserRel
{
    const ROLE = "role";
    const PROFILE = "profile";
    const GV_PHONG_MAY = 'gvPhongMay';
    const KTV_PHONG_MAY = 'ktvPhongMay';
    const LICH_DAY = 'lichDay';
    const DANG_KY_NGHI = 'dangKyNghi';
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
        'name', 'email', 'password','role_id','google_id'
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
        return $this->belongsTo('App\Models\Role', 'role_id');
    }

    //hasOne la quan he 1-1
    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    }

    public function gvPhongMay()
    {
        return $this->belongsToMany('App\Models\PhongMay', 'api_phong_may_user_elation', 'gv_id', 'phong_may_id');
    }

    public function ktvPhongMay()
    {
        return $this->belongsToMany('App\Models\PhongMay', 'api_phong_may_user_elation', 'ktv_id', 'phong_may_id');
    }

    public function lichDay()
    {
        return $this->hasMany('App\Models\LichDay','user_id');
    }

    public function dangKyNghi()
    {
        return $this->belongsTo('App\Models\DangKyNghi','user_id');
    }

    public function getUserQuery()
    {
        return $this->with(UserRel::ROLE)
            ->with(UserRel::PROFILE)
            ->with(UserRel::LICH_DAY)
            ->with(UserRel::DANG_KY_NGHI);
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
