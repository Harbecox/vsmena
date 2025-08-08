<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\PositionsRequest;

class PositionsController extends Controller
{
    function index()
    {
        $positions = Positions::query()
            ->select(['name', 'price_shifts', 'price_hour', 'description', 'slug', 'user_id', 'price_month', 'restaurants_id'])
            ->get();
























































































































        return view('positions.index',['positions' => $positions]);
    }
}
