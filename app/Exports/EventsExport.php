<?php

namespace App\Exports;

use App\Event;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	public function __construct($restaurants_id, $users_id, $start_date, $end_date) {
        $this->restaurants_id = $restaurants_id;
		$this->users_id = $users_id;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
	}
    public function collection()
    {
		if ($this->restaurants_id != 0 && $this->users_id != 0) {
			return Event::select("users.fio as usrfio", "positions.name as posname", "restaurants.name as restname",'events.start_date',
									'events.end_date', DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour as payment"), "events.title")
									->join("positions", "events.positions_id", "positions.id")
									->join("users", "positions.users_id", "users.id")
									->join("restaurants", "positions.restaurants_id", "restaurants.id")
									->where([['events.status', '=', '1'],['restaurants.id', '=', $this->restaurants_id],['users.id', '=', $this->users_id]])
									->whereBetween('events.start_date', [$this->start_date, $this->end_date])->get();
		} else if ($this->restaurants_id != 0 && $this->users_id == 0) {
			return Event::select("users.fio as usrfio", "positions.name as posname", "restaurants.name as restname",'events.start_date',
									'events.end_date', DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour as payment"), "events.title")
									->join("positions", "events.positions_id", "positions.id")
									->join("users", "positions.users_id", "users.id")
									->join("restaurants", "positions.restaurants_id", "restaurants.id")
									->where([['events.status', '=', '1'],['restaurants.id', '=', $this->restaurants_id]])
									->whereBetween('events.start_date', [$this->start_date, $this->end_date])->get();
		} else if ($this->restaurants_id == 0 && $this->users_id != 0) {
			return Event::select("users.fio as usrfio", "positions.name as posname", "restaurants.name as restname",'events.start_date',
									'events.end_date', DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour as payment"), "events.title")
									->join("positions", "events.positions_id", "positions.id")
									->join("users", "positions.users_id", "users.id")
									->join("restaurants", "positions.restaurants_id", "restaurants.id")
									->where([['events.status', '=', '1'],['users.id', '=', $this->users_id]])
									->whereBetween('events.start_date', [$this->start_date, $this->end_date])->get();
		} else if ($this->restaurants_id == 0 && $this->users_id == 0) { 
			return Event::select("users.fio as usrfio", "positions.name as posname", "restaurants.name as restname",'events.start_date',
									'events.end_date', DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), "positions.price_hour", DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour as payment"), "events.title")
									->join("positions", "events.positions_id", "positions.id")
									->join("users", "positions.users_id", "users.id")
									->join("restaurants", "positions.restaurants_id", "restaurants.id")
									->where('events.status', '=', '1')
									->whereBetween('events.start_date', [$this->start_date, $this->end_date])->get();
		}
    }
	
	public function headings() :array
    {
        return ["ФИО сотрудника", "Должность", "Ресторан","Время начала смены", "Время окончания смены", "Длительность смены", "Цена за час", "Оплата за смену", "Статус смены"];
    }
}
