<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailMoneyRequest extends Model
{
    protected $table = 'detail_money_req';
    protected $primaryKey = 'id_detail';
    protected $fillable = ['id_money_req', 'tipe', 'date', 'transfer',  'note', 'total_tf', 'nama'];
}
