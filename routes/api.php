<?php

use App\Http\Controllers\ValidateController;
use App\Models\Positions;
use App\Models\Restaurants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('validator/{validator}', [ValidateController::class,'validate'])
    ->name('validator');

Route::get('restaurants', function () {
    return response()->json(Restaurants::query()
        ->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->toArray());
});

Route::get('positions/{id}', function ($id) {
    return response()->json(Positions::query()->where('restaurants_id', request('id'))->get()->map(function ($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
        ];
    })->toArray());
});

Route::post('post_test',function (\App\Http\Requests\TestRequest $request){
     return response()->json($request->validated());
});
