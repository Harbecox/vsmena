<?php

namespace App\Livewire;

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
        $this->restaurants = Restaurants::query()->pluck('name','id')->toArray();
    }

    public function getListeners(): array
    {
        $props = $this->getProperties();
        $listeners = [];
        foreach ($props as $prop) {
            $listeners[$prop . '_Update'] = 'setValue';
        }
        return $listeners;
    }

    public function setValue($data)
    {
        $props = $this->getProperties();
        $key = $data['key'] ?? null;
        $value = $data['value'] ?? null;
        if($key && $value && in_array($key, $props)) {
            $this->$key = $value;
        }
    }

    public function render()
    {
        if($this->restaurant_id) {
            $this->positions = Positions::query()->where('restaurants_id', $this->restaurant_id)
                ->pluck('name','id')->toArray();
        }
        return view('livewire.add-event');
    }


    function getProperties(): array
    {
        $reflection = new \ReflectionClass($this);

        $props = collect($reflection->getProperties())
            ->filter(fn($prop) => $prop->getDeclaringClass()->getName() === static::class);

        $ownVars = [];

        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $ownVars[$prop->getName()] = $prop->getValue($this);
        }
        return array_keys($ownVars);
    }

}
