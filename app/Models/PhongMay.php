<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
abstract class PhongMayRel{
//    const demo = 'demo';
}
class PhongMay extends Model
{
    protected $table = "api_phong_may";

    protected $fillable = [
        'id',
        'name',
    ];
    public function giangVien()
    {
        return $this->belongsToMany('App\User','api_phong_may_user_elation','phong_may_id','gv_id');
    }
    public function kyThuatVien()
    {
        return $this->belongsToMany('App\User','api_phong_may_user_elation','phong_may_id','ktv_id');
    }
    public $timestamps = true;
}
