<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POAssetMSP extends Model
{
    protected $table = 'tb_po_asset_msp';
    protected $primaryKey = 'id_po_asset';
    protected $fillable = ['nik_admin', 'date_handover', 'no_po', 'nominal', 'due_date', 'ket_pr', 'note_pr','status_po','personel', 'address', 'telp', 'fax', 'email', 'attention', 'project', 'project_id', 'term','no_invoice'];
}
