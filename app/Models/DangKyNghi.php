<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
abstract class DangKyNghiRel
{
    const GIANG_VIEN = 'GiangVien';
    const USER = 'User.profile';
    const LICH_DAY = 'LichDay.tuan';

}
class DangKyNghi extends Model
{
    protected $table = "api_dang_ky_nghi";

    protected $fillable = [
        'id',
        'user_id',
        'lich_day_id',
        'description',
        'status',
        'gv_id',
        'tuan_id'
    ];
    public $timestamps = true;
    //belongsto 1-N
    //hasMany N-1
    //hasOne 1-1
    //belongstoMany N-N
    public function GiangVien()
    {
       return $this->belongsTo('App\User','gv_id');
    }
    public function LichDay()
    {
        return $this->belongsTo('App\Models\LichDay','lich_day_id');
    }
    public function User()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function DangKyNghiQuery()
    {
        return $this->with(DangKyNghiRel::GIANG_VIEN)->with(DangKyNghiRel::LICH_DAY)->with(DangKyNghiRel::USER);
    }

}
