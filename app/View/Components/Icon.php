<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $svg = "";
        $path = resource_path('icons/' . $this->name . '.svg');
        if (file_exists($path)) {
            $svg = file_get_contents($path);
        }
        return view('components.icon',['svg' => $svg]);
    }
}
