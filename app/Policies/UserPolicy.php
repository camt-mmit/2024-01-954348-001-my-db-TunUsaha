<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, User $user = null): bool
    {
        // If currentUser is an admin, allow them to update any user's info
        if ($currentUser->role === 'ADMIN') {
            return true;
        }

        // If not an admin, only allow updating their own info
        // Note: $user might be null when called from Gate::authorize('update', User::class)
        return $user !== null && $currentUser->id === $user->id;
    }


    public function create(User $currentUser): bool
    {
        return $currentUser->isAdministrator();
    }

    public function delete(User $currentUser, User $user): bool
    {
        // Allow deleting other users but not oneself
        return $currentUser->id !== $user->id;
    }
}
