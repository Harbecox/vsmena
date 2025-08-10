<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RewardModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $users = User::all()->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->fio
                ];
            })->toArray();
        return view('components.reward-modal',['users' => $users]);
    }
}
