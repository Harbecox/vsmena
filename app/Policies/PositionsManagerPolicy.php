<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionsManagerPolicy
{
    use HandlesAuthorization;

    public function manipulate(User $user): bool
    {
        return $user->role == "e";
    }
}
