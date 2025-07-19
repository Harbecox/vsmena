<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Positions extends Model
{
    protected $fillable = ["name", "price_shifts", "price_hour", "description", "slug", "users_id", "price_month", "restaurants_id"];

    public function usr() {
        return $this->belongsTo("App\User", "users_id", "id");
    }

    public function events() {
        return $this->hasMany("App\Event", "positions_id", "id");
    }

    public function logs() {
        return $this->hasMany("App\Logs", "positions_id", "id");
    }

    public function rst() {
        return $this->belongsTo("App\Restaurants", "restaurants_id", "id");
    }

    public function getRouteKeyName() {
        return "slug";
    }
}
