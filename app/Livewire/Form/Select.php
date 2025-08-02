<?php

namespace App\Livewire\Form;

use Livewire\Component;

class Select extends Component
{
    public string $name = '';
    public string $value = '';
    public array $options = [];
    public string $label = '';
    public string $var = '';

    public function render()
    {
        return view('livewire.form.select');
    }

    public function updated($propertyName,$value){
        ///$this->dispatch($this->var."_Update",['key'=>$this->var,'value'=>$value]);
    }
}
