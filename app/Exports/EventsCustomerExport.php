<?php

namespace App\Exports;

use App\Helpers\Helper;
use App\Models\Event;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventsCustomerExport implements FromCollection, WithHeadings, WithMapping
{
    private $start_date;
    private $end_date;
    private $restaurants_id = -1;
    private $status = -1;
    public function __construct($start_date, $end_date, $restaurants_id, $status) {
        $this->restaurants_id = $restaurants_id;
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Event::query()
            ->select(
                'restaurants.name as restname',
                'restaurants.id as restid',
                'positions.name as posname',
                'events.start_date',
                'events.end_date',
                'events.status'
            )
            ->join("positions", "events.positions_id", "positions.id")
            ->join("users", "positions.users_id", "users.id")
            ->join("restaurants", "positions.restaurants_id", "restaurants.id")
            ->where('users.id', '=', auth()->user()->id)
            ->whereBetween('events.start_date', [$this->start_date,$this->end_date] );
        if($this->status != -1){
            $query = $query->where('events.status', '=', $this->status);
        }
        if($this->restaurants_id != -1){
            $query = $query->where('events.restid', '=', $this->restaurants_id);
        }
        return $query->get();
    }

	public function headings() :array
    {
        return ['Ресторан ','Должность','Время начала','Время окончания','Длительность смены','Статус смены'];
    }

    public function map($row): array
    {
        return array(
            $row->restname,
            $row->posname,
            $row->start_date,
            $row->end_date,
            Helper::formatDurationRoundedHours($row->start_date,$row->end_date),
            $this->formatStatus($row->status),
        );
    }

    protected function formatStatus($status)
    {
        return match ((string) $status) {
            '1' => 'Подтверждена',
            '0' => 'Не подтверждена',
            default => 'Неизвестно',
        };
    }
}
