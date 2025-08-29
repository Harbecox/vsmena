<?php

namespace App\View\Components\Form\Table;

use App\Helpers\Helper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Date extends Component
{
    public ?string $date;
    public function __construct($date)
    {
        $this->date = $date ? Helper::formatRussianDate($date) : "-";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table.date',['date' => $this->date,]);
    }

}
