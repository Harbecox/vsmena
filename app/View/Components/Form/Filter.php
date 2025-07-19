<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class Filter extends Component
{
    public string $name;
    public array $values;
    public string $selected_label;
    public string|null $selected_value = null;
    public string $title;
    public string|null $icon;
    public string $base_url;
    public string $clear_url;
    public function __construct($name,$title,$empty_label,$values = [],$icon = null)
    {
        $this->name = $name;
        $this->values = $values;
        $this->selected_label = $empty_label;
        $this->icon = $icon;
        $this->title = $title;
        $this->base_url = $this->generateUrl();
        $this->clear_url = $this->generateClearUrl();
        $this->getSelected();
    }

    public function render(): View|Closure|string
    {
        return view('components.form.filter',
            [
                'values' => $this->values,
                'name' => $this->name,
                'selected_label' => $this->selected_label,
                'selected_value' => $this->selected_value,
                'title' => $this->title,
                'icon' => $this->icon,
                'base_url' => $this->base_url,
                'clear_url' => $this->clear_url,
            ]);
    }

    function getSelected()
    {
        $query = Request::query();
        if(isset($query[$this->name])){
            $this->selected_value = $query[$this->name];
            $this->selected_label = $this->values[$this->selected_value];
        }
    }

    function generateUrl(): string
    {
        $new_query = array_filter(Request::query(), function ($key) {
            return $key != $this->name;
        }, ARRAY_FILTER_USE_KEY);
        return Request::url().'?'.http_build_query($new_query)."&".$this->name."=";
    }

    function generateClearUrl(): string
    {
        $new_query = array_filter(Request::query(), function ($key) {
            return $key != $this->name;
        }, ARRAY_FILTER_USE_KEY);
        return Request::url().'?'.http_build_query($new_query);
    }
}
