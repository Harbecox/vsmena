<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Models\Positions;
use App\Models\Restaurants;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class AddEvent extends Component
{
    public $restaurant_id = 0;
    public $restaurants;
    public $position_id = 0;
    public $positions;

    function mount(): void
    {
        $this->restaurants = Helper::toMaryOptions(Restaurants::query()->pluck('name','id')
            ->toArray());
        $this->restaurant_id = 0;
    }

    public function render()
    {
        if($this->restaurant_id) {
            $this->positions = Positions::query()->where('restaurants_id', $this->restaurant_id)
                ->pluck('name','id')->toArray();
            $this->positions = Helper::toMaryOptions($this->positions);
        }
        return view('livewire.add-event');
    }

}
