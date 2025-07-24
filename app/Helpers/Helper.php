<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
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

    public static function role_to_russian($role = null): string
    {
        $role = $role ?? auth()->user()->role;
        return match ($role) {
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

    static function formatRussianDate($date,$withTime = true): string
    {
        App::setLocale('ru');
        Carbon::setLocale('ru');

        try {
            $carbon = Carbon::parse($date);
        } catch (\Exception $e) {
            return $date;
        }
        if($withTime){
            return $carbon->translatedFormat('j M Y, H:i');
        }else{
            return $carbon->translatedFormat('j M Y');
        }
    }

    static function parseRuDate(string $string): ?string
    {
        $months = [
            'янв' => 'Jan', 'фев' => 'Feb', 'мар' => 'Mar', 'апр' => 'Apr',
            'май' => 'May', 'июн' => 'Jun', 'июл' => 'Jul', 'авг' => 'Aug',
            'сен' => 'Sep', 'окт' => 'Oct', 'ноя' => 'Nov', 'дек' => 'Dec',
        ];

        foreach ($months as $ru => $en) {
            if (str_contains($string, $ru)) {
                $string = str_replace($ru, $en, $string);
                break;
            }
        }

        try {
            $date = Carbon::createFromFormat('d M Y, H:i', $string);
            return $date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // Не удалось распарсить дату — возвращаем null
            return null;
        }
    }
}
