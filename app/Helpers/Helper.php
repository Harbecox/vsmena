<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Request;

class Helper
{
    static function check_day_night($start,$status): bool
    {

        $flag_ = false;

        if (time() - strtotime($start) <= 24*60*60) {

            //---------------- not end day-night ------------------

            if ($status == 3) $flag_ = true;

        }

        return $flag_;

    }

    public static function role_to_russian(): string
    {
        if(!auth()->check()){
            return "";
        }
        return match (auth()->user()->role) {
            'a' => 'Сотрудник',
            'e' => 'Менеджер',
            'b' => 'Бухгалтер',
            'm' => 'Администратор',
            default => 'Неизвестная роль',
        };
    }

    static function formatDurationRoundedHours(string $start, string $end): string
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        $minutes = $start->diffInMinutes($end);
        $hours = round($minutes / 60);

        $word = match (true) {
            $hours === 1 => 'час',
            $hours >= 2 && $hours <= 4 => 'часа',
            default => 'часов',
        };

        return "{$hours} {$word}";
    }

    static function paginateArray(array $items, int $perPage = 10, int $page = null, array $options = [])
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage();

        $collection = collect($items);
        $currentPageItems = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $collection->count(),
            $perPage,
            $page,
            $options + ['path' => Request::url(), 'query' => Request::query()]
        );
    }
}
