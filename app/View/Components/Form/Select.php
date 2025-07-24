<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public array $values;
    public string $label;
    public function __construct($name,$label,$values = [])
    {
        $this->name = $name;
        $this->values = $values;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.select',[
                "values" => $this->values,
                "name" => $this->name,
                "label" => $this->label,
            ]);
    }
}
