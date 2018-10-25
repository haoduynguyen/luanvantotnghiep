<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhongMayUserRelation extends Model
{
    protected $table = "api_phong_may_user_relation";

    protected $fillable = [
        'id',
        'phong_may_id',
        'gv_id',
        'ktv_id',
        'mota_gv',
        'mota_ktv',
    ];
//    public function phongMay()
//    {
//        return $this->hasMany('App\Models\PhongMay','phong_may_id');
//    }
//    public function giangVien()
//    {
//        return $this->hasMany('App\User','gv_id');
//    }
//    public function ktThuatVien()
//    {
//        return $this->hasMany('App\User','ktv_id');
//    }
    public $timestamps = true;
}
