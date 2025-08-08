<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $fillable = ["name", "slug", "description","session_id"];

    public function positions() {
        return $this->hasMany(Positions::class, "restaurants_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
