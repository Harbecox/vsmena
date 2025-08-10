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
    public string $selected = '';
    public string $class = '';
    public function __construct($name,$label,$values = [],$selected = '',$class = '')
    {
        $this->name = $name;
        $this->values = $values;
        $this->label = $label;
        $this->selected = $selected;
        $this->class = $class;
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
                "selected" => $this->selected,
                "class" => $this->class,
            ]);
    }
}
