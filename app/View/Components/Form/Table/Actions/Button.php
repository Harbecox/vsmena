<?php

namespace App\View\Components\Form\Table\Actions;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public string $title = '';
    public string $type = 'primary';
    public string $icon = '';
    public string $url = '';
    public function __construct($title, $type = 'primary',$icon = '', $url = '')
    {
        $this->title = $title;
        $this->type = $type;
        $this->icon = $icon;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table.actions.button',[
            'title' => $this->title,
            'type' => $this->type,
            'icon' => $this->icon,
            'url' => $this->url,
        ]);
    }
}
