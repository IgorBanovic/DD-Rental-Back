<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function view(User $authUser, User $user): bool
    {
        if($authUser->is_admin)
            return true;
        return $authUser->id === $user->id;
    }

    public function update(User $authUser, User $user): bool
    {
        if($authUser->is_admin)
            return true;
        return $authUser->id === $user->id;
    }
}
