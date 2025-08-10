<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ["title", "admin_id", "object"];

    static function Log($object,$title): void
    {
        static::create([
            "admin_id" => auth()->user()->id,
            'title' => $title,
            "object" => $object,
        ]);
    }

    function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id','id');
    }
}
