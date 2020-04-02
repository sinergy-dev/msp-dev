<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory_msp extends Model
{
    protected $table = 'inventory_produk_msp';
    protected $primaryKey = 'id_product';
    protected $fillable = ['kode_barang','nama','kategori','tipe','sn','qty','unit','note', 'qty_sisa_submit'];
}
