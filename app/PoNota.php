<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoNota extends Model
{
    protected $table = 'tb_po_nota';
    protected $primaryKey = 'id';
    protected $fillable = ['no_po'];
}
