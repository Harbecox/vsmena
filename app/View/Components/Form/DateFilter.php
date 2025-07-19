<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateFilter extends Filter
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
        parent::__construct($name,$title,$empty_label,$values = [],$icon = null);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.date-filter',
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
}
