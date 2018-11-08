<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'hk_id'
    ];
    public $timestamps = true;
}
