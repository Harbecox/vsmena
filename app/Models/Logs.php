<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table="logs";
    protected $fillable=["date_add","title","admin_id","positions_id"];

    public function pst() {
        return $this->belongsTo("App\Positions", "positions_id", "id");
    }
}
