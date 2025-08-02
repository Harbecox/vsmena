<?php

namespace App\Livewire\Form;

use Livewire\Component;

class TestComponent extends Component
{
    public $value;

    public function render()
    {
        return view('livewire.form.test-component');
    }

    public function value_plus()
    {
        $this->value++;
        $this->dispatch('restaurant_id_Update', ['key' => 'restaurant_id','value' => $this->value]);
    }
}
