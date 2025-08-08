<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $text,
        public string $url,
        public int $id,
    )
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-modal',[
            'title' => $this->title,
            'text' => $this->text,
            'url' => $this->url,
            'id' => $this->id,
        ]);
    }
}
