<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CalendarRequest;
use App\Models\Event;
use App\Models\Positions;
use App\Models\Restaurants;
use App\View\Components\Form\Table\AcctionApprove;
use App\View\Components\Form\Table\Date;
use App\View\Components\Form\Table\Text;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::orderBy('start_date')
            ->get()
            ->groupBy(fn($event) => Carbon::parse($event->start_date)->toDateString())
            ->map(fn($group) => $group->every(fn($event) => $event->status != 0));
        $filters = [];
        $calendar = new Collection();
        $month = Carbon::now()->startOfMonth();
        $current_month = $month->month;
        while($month->month == $current_month){
            $calendar->push([
                'value' => $month->day,
                'type' => 'current',
                'date' => $month->toDateString(),
                'status' => isset($events[$month->toDateString()]) ? ($events[$month->toDateString()] ? 1 : -1) : 0
            ]);
            $month->addDay();
        }
        $month = $month->subMonth()->startOfMonth();
        $day = $month->dayOfWeek();
        for($i = 1; $i < $day;$i++){
            $month->subDay();
            $calendar->prepend([
                'value' => $month->day,
                'type' => 'prev',
                'date' => $month->toDateString(),
                'status' => isset($events[$month->toDateString()]) ? ($events[$month->toDateString()] ? 1 : -1) : 0
            ]);
        }
        $month->addMonth()->endOfMonth()->addDay();
        while($calendar->count() < 35){
            $calendar->push([
                'value' => $month->day,
                'type' => 'next',
                'date' => $month->toDateString(),
                'status' => isset($events[$month->toDateString()]) ? ($events[$month->toDateString()] ? 1 : -1) : 0
            ]);
            $month->addDay();
        }
        return view('calendar.index', compact('filters','calendar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurants = Restaurants::query()->pluck('name','id')->toArray();
        $positions = Positions::query()->pluck('name','id')->toArray();
        return view('calendar.create', compact('restaurants','positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CalendarRequest $request)
    {
        $data = $request->except('restaurant_id');
        Event::create($data);
        return redirect()->route('calendar.show', Carbon::parse($data['end_date'])->format('Y-m-d'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $date)
    {
        $carbon = Carbon::parse($date);
        $filters = [];
        $events = Event::query()
            ->select("events.*", "positions.name as posname", "restaurants.name as restname",
                "positions.payment_amount","users.fio as fio")
                ->join("positions", "events.positions_id", "positions.id")
                ->join("users", "events.user_id", "users.id")
                ->join("restaurants", "positions.restaurants_id", "restaurants.id")
            ->whereBetween("events.start_date", [$carbon->startOfDay()->format('Y-m-d H:i:s'), $carbon->endOfDay()->format('Y-m-d H:i:s')])
            ->get();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                new Text($event->restname),
                new Text($event->posname),
                new Text($event->fio),
                new Date($event->start_date),
                new Date($event->end_date),
                new AcctionApprove($event->status,$event->id)
                //new Text($event->status ? 'Подтверждена' : 'Не подтверждена')
            ];
        }
        $data = Helper::paginateArray($data);

        return view('calendar.show', ['date' => $date,'events' => $data,'filters' => $filters]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::find($id);
        $restaurants = Restaurants::query()->pluck('name','id')->toArray();
        $positions = Positions::query()->pluck('name','id')->toArray();
        return view('calendar.edit', [
            'event' => $event,
            'restaurants' => $restaurants,
            'positions' => $positions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CalendarRequest $request, string $id)
    {
        $event = Event::query()
            ->where('id','=', $id)
            ->first();
        dd($request->validated());
        /** TODO */
        return redirect()->route('calendar.show', Carbon::parse($event->start_date)->toDateString());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::destroy($id);
        return back();
    }

    public function accept(string $id)
    {
        Event::query()->where("id", $id)->update(["status" => 1]);
        return back();
    }
}
