<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project_msp_changelog extends Model
{
    protected $table = 'change_log_project_msp';
    protected $primaryKey = 'id_changelog_project_msp';
    protected $fillable = ['fk_id_detail_do_msp','created_at','updated_at','to_agen','address','telp','fax','attn','from','subj','date','id_project','qty_transac','id_transaction','no_do','fk_id_product','id_detail_do'];
}
