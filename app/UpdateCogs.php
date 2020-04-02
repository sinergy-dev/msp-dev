<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateCogs extends Model
{
    protected $table = 'change_log_cogs';
    protected $primaryKey = 'id_cogs';
    protected $fillable = ['cogs_edit', 'note_edit', 'id_money_req'];
}
