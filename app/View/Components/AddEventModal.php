<?php

namespace App\View\Components;

use App\Models\Event;
use App\Models\Positions;
use App\Models\Restaurants;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddEventModal extends Component
{
    public array $restaurants;
    public array $positions;
    public Event $event;
    public function __construct()
    {
        $this->event = Event::query()->where('user_id',auth()->user()->id)->orderByDesc('end_date')->first() ?? new Event();
        $this->restaurants = Restaurants::query()->pluck('name','id')->toArray();
        $this->positions = Positions::query()->pluck('name','id')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-event-modal',['restaurants' => $this->restaurants, 'positions' => $this->positions, 'event' => $this->event]);
    }
}
