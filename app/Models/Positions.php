<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{

    protected $fillable = ["name", 'payment_amount','payment_method', "description", "user_id", "restaurants_id"];

    function restaurant()
    {
        return $this->belongsTo(Restaurants::class, 'restaurants_id', 'id');
    }
}
