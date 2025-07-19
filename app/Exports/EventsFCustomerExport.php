<?php

namespace App\Exports;

use App\Event;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsFCustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	public function __construct($start_date, $end_date, $restaurants_id, $title) {
        $this->restaurants_id = $restaurants_id;
		$this->title = $title;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
	}
    public function collection()
    {
        return Event::select("positions.name as posname", "restaurants.name as restname","events.start_date","events.end_date", 
								 DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", 
								 DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour + events.premium as payment"),"events.title")
								->join("positions", "events.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")
								->where(DB::raw('DATE(events.start_date)'), '>=', $this->start_date)
								->where(DB::raw('DATE(events.end_date)'), '<=', $this->end_date)
								->where('positions.restaurants_id', '=', $this->restaurants_id)
								->where('events.title', '=', $this->title)
								->where('users.id', '=', auth()->user()->id)->get();
    }
	public function headings() :array
    {
        return ["Должность", "Ресторан","Время начала смены", "Время окончания смены", "Длительность смены", "Цена за час", "Оплата за смену", "Статус смены"];
    }
}
