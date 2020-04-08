<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoIdProject extends Model
{
    protected $table = 'tb_po_id_project';
    protected $primaryKey = 'id';
    protected $fillable = ['id_po', 'id_project'];
}
