<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CutiDetailMSP extends Model
{
    protected $table = 'tb_detail_cuti_msp';
    protected $primaryKey = 'id_cuti';
    protected $fillable = ['id_cuti','date_off'];
    public $timestamps = false;
}
