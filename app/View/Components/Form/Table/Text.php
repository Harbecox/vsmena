<?php

namespace App\View\Components\Form\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component
{
    public string $text;
    public $info;
    public int $limit;

    public function __construct($text,$info = null,$limit = 999)
    {
        $this->text = $text;
        $this->info = $info;
        $this->limit = $limit;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.table.text', [
            'text' => $this->text,
            'info' => $this->info,
            'limit' => $this->limit,
        ]);
    }
}
