<?php

namespace App\View\Components;

use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CalendarModal extends Component
{
    public array $day;
    public array $events;
    public function __construct($day)
    {
        $this->day = $day;
        $this->events = Event::query()->whereDate('start_date', $day['date'])
            ->with('user')->get()->map(function ($event) {
                return [
                    'status' => $event->status,
                    'fio' => $event->user->fio,
                ];
            })->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar-modal');
    }
}
