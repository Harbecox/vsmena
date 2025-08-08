<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Positions;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Text;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\PositionsRequest;

class PositionsController extends Controller
{
    function index()
    {
        $positions = Positions::query()
            ->select(['positions.name as name','positions.id as id','positions.price_shifts as price_shifts','positions.price_hour as price_hour','positions.description as description','restaurants.name as restaurant_name'])
            ->join('restaurants','positions.restaurants_id','=','restaurants.id')
            ->get();

        $data = [];
        foreach ($positions as $position) {
            $data[] = [
                new Text($position->restaurant_name),
                new Text($position->name),
                new Text($position->price_shifts),
                new Text($position->price_hour),
                new Text($position->description),
                new Actions()
            ];
        }
        $data = Helper::paginateArray($data);
        return view('positions.index',['positions' => $data]);
    }
}
