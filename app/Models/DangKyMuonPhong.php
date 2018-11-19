<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
abstract class DKMUONPHONGREL
{
    const HOC_KY = 'hocKy';
    const CA = 'ca';
    const PHONG_MAY = 'phongMay';
    const MON_HOC = 'MonHoc';
    const THU = 'thu';
    const USER = 'user.profile';
    const TUAN = 'tuan';
}
class DangKyMuonPhong extends Model
{
    protected $table = "api_dang_ky_muon_phong";

    protected $fillable = [
        'id',
        'phong_may_id',
        'mon_hoc_id',
        'ca_id',
        'status',
        'thu_id',
        'user_id',
        'hk_id',
    ];

    public $timestamps = true;
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
        return $this->hasMany('App\Models\TuanMuonPhongRelation','muon_phong_id');
    }
    public function dkMuonPhongQuery()
    {
        return $this->with(DKMUONPHONGREL::USER)
            ->with(DKMUONPHONGREL::CA)
            ->with(DKMUONPHONGREL::HOC_KY)
            ->with(DKMUONPHONGREL::MON_HOC)
            ->with(DKMUONPHONGREL::PHONG_MAY)
            ->with(DKMUONPHONGREL::THU)
            ->with(DKMUONPHONGREL::TUAN);
    }
}
