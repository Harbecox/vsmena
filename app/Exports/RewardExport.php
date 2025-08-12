<?php

namespace App\Exports;

use App\Enum\Reward;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RewardExport implements FromCollection, WithHeadings, WithMapping
{
    private $start_date;
    private $end_date;
    public function __construct($start_date, $end_date){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return \App\Models\Reward::query()
            ->whereBetween('date',[$this->start_date,$this->end_date])
            ->get();
    }

    public function headings(): array
    {
        return ['Кому выдано','Дата создания','Дата выдачи','Премия или штраф','Комментарий','Ответственный'];
    }

    public function map($row): array
    {
        return [
            $row->user->fio,
            $row->created_at,
            $row->date,
            Reward::from($row->type)->label() . " " . $row->amount,
            $row->comment,
            $row->admin->fio,
        ];
    }
}
