<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class PhongMayUserRelationRel
{
    const PHONG_MAY = 'phongMay';
    const GIANG_VIEN = 'giangVien.profile';
    const KY_THUAT_VIEN = 'kyThuatVien.profile';
    const Mon_Hoc = 'monHoc';
}

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
        'status',
        'mon_hoc_id',
    ];

    public function phongMay()
    {
        return $this->belongsTo('App\Models\PhongMay', 'phong_may_id');
    }

    public function giangVien()
    {
        return $this->belongsTo('App\User', 'gv_id');
    }

    public function kyThuatVien()
    {
        return $this->belongsTo('App\User', 'ktv_id');
    }
    public function monHoc()
    {
        return $this->belongsTo('App\Models\MonHoc', 'mon_hoc_id');
    }

    public function PhongMayUserRelationQuery()
    {
        return $this->with(PhongMayUserRelationRel::GIANG_VIEN)
            ->with(PhongMayUserRelationRel::KY_THUAT_VIEN)
            ->with(PhongMayUserRelationRel::PHONG_MAY)
            ->with(PhongMayUserRelationRel::Mon_Hoc);
    }

    public $timestamps = true;
}
