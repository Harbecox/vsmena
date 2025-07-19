<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurants extends Model
{
    protected $fillable = ["name", "slug", "description","session_id"];

    public function positions() {
        return $this->hasMany("App\Positions", "restaurants_id", "id");
    }
    public function getRouteKeyName() {
        return "slug";
    }
}
