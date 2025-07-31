<?php

namespace App\View\Components\Form\Table\Actions;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IconLink extends Component
{
    public string|null $url = '';
    public string $icon = '';
    public string $title = '';
    public function __construct($url, $icon = null, $title = '')
    {
        $this->icon = $icon;
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table.actions.icon-link',[
            'url' => $this->url,
            'icon' => $this->icon,
            'title' => $this->title,
        ]);
    }
}
