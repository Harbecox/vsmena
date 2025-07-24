<?php

use App\Http\Controllers\ValidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('validator/{validator}', [ValidateController::class,'validate'])
    ->name('validator');
