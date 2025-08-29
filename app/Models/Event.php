<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table="events";
    protected $fillable=["title","color","start_date","end_date","positions_id","status","premium","user_id"];

    public function pst() {
        return $this->belongsTo("App\Positions", "positions_id", "id");
    }

    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Positions::class, 'positions_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
