<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class tuanMuonPhongRelationRel
{
    const TUAN = 'tuan';
    const MUON_PHONG = 'dangKyMuonPhong';
}

class TuanMuonPhongRelation extends Model
{
    protected $table = 'api_tuan_muon_phong_relation';
    protected $fillable = [
        'tuan_id',
        'muon_phong_id',
        'status'
    ];

    public function tuan()
    {
        return $this->belongsTo('App\Models\Tuan', 'tuan_id');
    }

    public function dangKyMuonPhong()
    {
        return $this->belongsTo('App\Models\DangKyMuonPhong', 'muon_phong_id');
    }

    public function tuanMuonPhongReletionQuery()
    {
        return $this->with(tuanMuonPhongRelationRel::TUAN)
                ->with(tuanMuonPhongRelationRel::MUON_PHONG);
    }

    public $timestamps = true;
}
