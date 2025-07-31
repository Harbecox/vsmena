<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public array $columns;
    public mixed $items;
    public string $fbTitle = '';
    public string $fbUrl = '';

    public function __construct(array $columns, mixed $items, string $fbTitle = "", string $fbUrl = "")
    {
        $this->columns = $columns;
        $this->items = $items;
        $this->fbTitle = $fbTitle;
        $this->fbUrl = $fbUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table');
    }
}
