<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventInfoModal extends Component
{

    public function render(): View|Closure|string
    {
        return view('components.event-info-modal');
    }
}
