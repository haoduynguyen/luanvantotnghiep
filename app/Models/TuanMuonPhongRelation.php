<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TuanMuonPhongRelation extends Model
{
    protected $table = 'api_tuan_muon_phong_relation';
    protected $fillable =[
        'tuan_id',
        'muon_phong_id',
        'status'
    ];
    public $timestamps = true;
}
