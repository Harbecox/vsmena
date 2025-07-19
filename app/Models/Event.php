<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table="events";
    protected $fillable=["title","color","start_date","end_date","positions_id","status","premium"];

    public function pst() {
        return $this->belongsTo("App\Positions", "positions_id", "id");
    }

}
