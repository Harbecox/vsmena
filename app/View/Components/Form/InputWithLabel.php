<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputWithLabel extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string      $label,
        public string      $placeholder = '',
        public string      $name,
        public string      $value = '',
        public string      $type = 'text',
        public string|null $icon = null,
        public bool        $required = false,
        public bool        $looked = false,
        public string      $class = ""
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input-with-label');
    }
}
