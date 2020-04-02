<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryAssetMSP extends Model
{
    protected $table = 'inventory_asset_msp';
    protected $primaryKey = 'id';
    protected $fillable = ['nama','kode_barang','kategori','qty','note'];
}
