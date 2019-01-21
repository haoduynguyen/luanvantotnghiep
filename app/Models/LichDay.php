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
    const USER = 'user.profile';
    const TUAN = 'tuan';
    const DANG_KY_NGHI = 'dangKyNghi';
    const BAO_CAO_PHONG_MAY = 'baoCaoPhongMay';
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
        'tuan_mon',
        'ca_id',
    ];
    public function baoCaoPhongMay()
    {
        return $this->hasOne('App\Models\PhongMayUserRelation','lich_day_id');
    }
    public function hocKy()
    {
        return $this->belongsTo('App\Models\HocKy','hk_id');
    }
    public function ca()
    {
        return $this->belongsTo('App\Models\Ca','ca_id');
    }
    public function phongMay()
    {
        return $this->belongsTo('App\Models\PhongMay','phong_may_id');
    }
    public function nhomLop()
    {
        return $this->belongsTo('App\Models\NhomLop','nhom_lop_id');
    }
    public function MonHoc()
    {
        return $this->belongsTo('App\Models\MonHoc','mon_hoc_id');
    }
    public function thu()
    {
        return $this->belongsTo('App\Models\Thu','thu_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function tuan()
    {
        return $this->hasMany('App\Models\LichDayTuanRelation','lich_day_id');
    }
    public function dangKyNghi()
    {
        return $this->hasOne('App\Models\DangKyNghi','lich_day_id')->orderBy('created_at','desc');
    }
    public function lichDayQuery()
    {
        return $this->with(LichDayRel::USER)
            ->with(LichDayRel::CA)
            ->with(LichDayRel::HOC_KY)
            ->with(LichDayRel::MON_HOC)
            ->with(LichDayRel::NHOM_LOP)
            ->with(LichDayRel::PHONG_MAY)
            ->with(LichDayRel::THU)
            ->with(LichDayRel::TUAN)
            ->with(LichDayRel::DANG_KY_NGHI)
            ->with(LichDayRel::BAO_CAO_PHONG_MAY);
    }
    public $timestamps = true;
}
