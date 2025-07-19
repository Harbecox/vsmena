<?php

namespace App\Exports;

use App\Event;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsCustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Event::select("positions.name as posname", "restaurants.name as restname","events.start_date","events.end_date", 
								 DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", 
								 DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour + events.premium as payment"),"events.title")
								->join("positions", "events.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where('events.status','=','1')
								->where('users.id', '=', auth()->user()->id)->orderBy("events.start_date", "asc")->get();
    }
	
	public function headings() :array
    {
        return ["Должность", "Ресторан","Время начала смены", "Время окончания смены", "Длительность смены", "Цена за час", "Оплата за смену", "Статус смены"];
    }
}
