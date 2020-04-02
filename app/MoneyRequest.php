<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoneyRequest extends Model
{
    protected $table = 'money_req';
    protected $primaryKey = 'id_money_req';
    protected $fillable = ['id_project', 'project_name', 'cogs', 'nik',  'cogs_akhir', 'cogs_note', 'cogs_update'];
}
