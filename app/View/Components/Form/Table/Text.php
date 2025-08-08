<?php

namespace App\View\Components\Form\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public string $text;
    public $info;

    public function __construct($text,$info = null)
    {
        $this->text = $text;
        $this->info = $info;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.table.text', [
            'text' => $this->text,
            'info' => $this->info
        ]);
    }
}
