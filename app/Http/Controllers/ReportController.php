<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Helpers\Helper;
use App\Models\Event;
use App\Models\Restaurants;
use App\View\Components\Form\DateFilter;
use App\View\Components\Form\Filter;
use App\View\Components\Form\Table\Text;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function index()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        if(!isset($filters_params['date'])){
            $from = Carbon::now()->subMonth()->format('Y-m-d');
            $to = Carbon::now()->format('Y-m-d');
            $filters_params['date'] = $from.','.$to;
            return redirect()->route('reports.index', $filters_params);
        }

        $query = Event::query()
            ->select(
                'events.status as status',
                'events.user_id as user_id',
                'positions.name as position',
                'positions.payment_amount as amount',
                'positions.payment_method as method',
                'restaurants.name as restaurant',
                'restaurants.id as restaurant_id',
                'users.fio as fio',
                'events.start_date as start_date',
                'events.end_date as end_date',
            )
            ->join('positions', 'events.positions_id', '=', 'positions.id')
            ->join('restaurants', 'positions.restaurants_id', '=', 'restaurants.id')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->where('events.status',1)
            ->where('positions.payment_method',PaymentMethod::PER_HOUR);

        if(isset($filters_params['restorant'])){
            $query = $query->where('restaurants.id', '=', $filters_params['restorant']);
        }
        $reports = $query->get();
        $data = [];
        foreach ($reports as $report) {
            $hours = round(Carbon::make($report->start_date)->diffInHours(Carbon::make($report->end_date)));
            $data[] = [
                new Text($report->restaurant),
                new Text($report->fio),
                new Text($report->position),
                new Text($hours),
                new Text($report->amount * $hours),
                new Text(""),
                new Text(""),
                new Text($report->amount * $hours),
            ];
        }
        $data = Helper::paginateArray($data);
        $restorans = Restaurants::query()->pluck("name", "id")->toArray();
        $filters[] = new Filter('restorant','Выбрать ресторан','Все рестораны',$restorans,'cookie');
        $filters[] = new DateFilter('date','Выбрать даты','--',[],'calendar');
        return view("report.index",['reports' => $data,'filters' => $filters]);
    }

    public function download()
    {

    }
}
