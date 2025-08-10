<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Event;
use App\Models\Positions;
use App\Models\Restaurants;
use App\View\Components\Form\Filter;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Actions\IconLink;
use App\View\Components\Form\Table\Date;
use App\View\Components\Form\Table\Text;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class StaffController extends Controller
{
    function index()
    {
        $filters_params = \request()->all();
        $query = Event::select("events.*", "positions.name as posname", "restaurants.name as restname"
            ,"users.fio as fio")
            ->join("positions", "events.positions_id", "positions.id")
            ->join("users", "positions.user_id", "users.id")
            ->join("restaurants", "positions.restaurants_id", "restaurants.id");
        if(isset($filters_params['restorant'])){
            $query = $query->where('restaurants.id', '=', $filters_params['restorant']);
        }
        $events = $query->get();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                new Text($event->restname),
                new Text($event->posname),
                new Date($event->fio),
                new Date($event->end_date),
                new Actions([new IconLink(route('staff.edit',$event->id),'edit')])
            ];
        }
        $data = Helper::paginateArray($data);
        $restorans = Restaurants::query()->pluck("name", "id")->toArray();
        $restorans['-1'] = 'Все рестораны';
        $filters[] = new Filter('restorant','Выбрать ресторан','Все рестораны',$restorans,'cookie');
        return view("staff.index",[
            "filters" => $filters,
            "events" => $data
        ]);
    }

    function edit($id)
    {
        $event = Event::query()
            ->join("positions", "events.positions_id", "positions.id")
            ->join("users", "positions.user_id", "users.id")
            ->where('events.id', '=', $id)
            ->first();
        $restaurants = Restaurants::query()->pluck('name','id')->toArray();
        $positions = Positions::query()->pluck('name','id')->toArray();
        return view("staff.edit",[
            'restaurants' => $restaurants,
            'positions' => $positions,
            'event' => $event
        ]);
    }

    function update(Request $request, $id)
    {
        /** todo **/
        return redirect()->route('staff.index');
    }

    function create()
    {
        $restaurants = Restaurants::query()->pluck('name','id')->toArray();
        $positions = Positions::query()->pluck('name','id')->toArray();
        return view("staff.create",[
            'restaurants' => $restaurants,
            'positions' => $positions,
        ]);
    }

    function store(Request $request)
    {
        /** todo **/
        return redirect()->route('staff.index');
    }
}
