<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pam_msp extends Model
{
    protected $table = 'tb_pam_msp';
    protected $primaryKey = 'id_pam';
    protected $fillable = ['nik_admin', 'date_handover', 'no_pr', 'nominal', 'due_date','status','personel','subject', 'to_agen', 'address', 'telp', 'fax', 'email', 'attention', 'project', 'project_id', 'ppn', 'term', 'file'];
}
