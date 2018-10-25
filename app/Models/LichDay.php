<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
abstract class LichDayRel
{
    const HOC_KY = 'hocKy';
    const CA = 'ca';
    const PHONG_MAY = 'phongMay';
    const NHOM_LOP = 'nhomLop';
    const MON_HOC = 'MonHoc';
    const THU = 'thu';
    const USER = 'user';
}
class LichDay extends Model
{
    protected $table = "api_lich_day";

    protected $fillable = [
        'id',
        'user_id',
        'phong_may_id',
        'hk_id',
        'thu_id',
        'nhom_lop_id',
        'mon_hoc_id',
        'tuan_hoc',
        'tuan_mon',
        'ca_id',
    ];
    public function hocKy()
    {
        return $this->hasMany('App\Models\HocKy','hk_id');
    }
    public function ca()
    {
        return $this->hasMany('App\Models\Ca','ca_id');
    }
    public function phongMay()
    {
        return $this->hasMany('App\Models\PhongMay','phong_may_id');
    }
    public function nhomLop()
    {
        return $this->hasMany('App\Models\NhomLop','nhom_lop_id');
    }
    public function MonHoc()
    {
        return $this->hasMany('App\Models\MonHoc','mon_hoc_id');
    }
    public function thu()
    {
        return $this->hasMany('App\Models\Thu','thu_id');
    }
    public function user()
    {
        return $this->hasMany('App\User','user_id');
    }

    public function lichDayQuery()
    {
        return $this->with(LichDayRel::USER)
            ->with(LichDayRel::CA)
            ->with(LichDayRel::HOC_KY)
            ->with(LichDayRel::MON_HOC)
            ->with(LichDayRel::NHOM_LOP)
            ->with(LichDayRel::PHONG_MAY)
            ->with(LichDayRel::THU);
    }
    public $timestamps = true;
}
