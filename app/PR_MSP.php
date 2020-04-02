<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PR_MSP extends Model
{
    protected $table = 'tb_pr_msp';
    protected $primaryKey = 'no';
    protected $fillable = ['no','no_pr', 'position', 'type_of_letter', 'month', 'date', 'to', 'attention', 'title', 'project', 'description', 'subject', 'from', 'division', 'issuance', 'id_project', 'project_id', 'subject', 'result'];
    public $timestamps = false;
}
