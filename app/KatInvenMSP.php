<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KatInvenMSP extends Model
{
    protected $table = 'cat_inventory_produk_msp';
    protected $primaryKey = 'id';
    protected $fillable = ['name','status'];
}
