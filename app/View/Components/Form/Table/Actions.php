<?php

namespace App\View\Components\Form\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Actions extends Component
{
    public array $buttons = [];
    public function __construct($buttons = [])
    {
        $this->buttons = $buttons;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table.actions',['buttons' => $this->buttons]);
    }
}
