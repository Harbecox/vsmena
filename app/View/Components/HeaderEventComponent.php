<?php

namespace App\View\Components;

use App\Models\Event;
use App\Models\Positions;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderEventComponent extends Component
{
    public $event_id = null;
    public function __construct()
    {
        $event = Positions::query()
            ->where('positions.user_id', '=', auth()->user()->id)
            ->where('events.user_id', '=', auth()->user()->id)
            ->rightJoin('events', 'events.positions_id', '=', 'positions.id')
            ->select('events.id')
            ->orderByDesc('events.id')
            ->first();
        $this->event_id = $event->id ?? null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-event-component',['event_id' => $this->event_id]);
    }
}
