<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseProjectMSPDetail extends Model
{
    protected $table = 'inventory_delivery_msp_transaction';
    protected $primaryKey = 'id_detail_do_msp';
    protected $fillable = ['id_transaction','qty_transac','note','unit','fk_id_product','created_at', 'updated_at', 'qty_submit'];
}
