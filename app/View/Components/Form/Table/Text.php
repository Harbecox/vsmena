<?php

namespace App\View\Components\Form\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public string $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.table.text', [
            'text' => $this->text,
        ]);
    }
}
