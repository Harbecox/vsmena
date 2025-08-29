<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ["title", "admin_id", "object"];

    static function Log($object,$title): void
    {
        if(is_string($object)){
            $object_text = $object;
        }elseif($object instanceof Positions){
            $object_text = $object->restaurant->name . " / " . $object->name;
        }elseif($object instanceof Restaurants){
            $object_text = $object->name;
        }elseif($object instanceof User) {
            $object_text = $object->fio;
        }elseif($object instanceof Reward){
            $object_text = $object->user->fio . " - " . $object->amount;
        }else{
            $object_text = " - - - ";
        }
        static::create([
            "admin_id" => auth()->user()->id,
            'title' => $title,
            "object" => $object_text,
        ]);
    }

    function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id','id');
    }
}
