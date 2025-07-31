<?php

namespace App\View\Components\Form\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AcctionApprove extends Component
{
    public $status;
    public $id;

    public function __construct($status, $id)
    {
        $this->status = $status;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.table.acction-approve',['status' => $this->status, 'id' => $this->id]);
    }
}
