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

    public function viewAny(User $user): bool
    {
        return $user->role === 'ADMIN';
    }

    public function update(User $currentUser, User $user): bool
{
    // If currentUser is an admin, allow them to update any user's info
    if ($currentUser->role === 'ADMIN') {
        return true; // Admin can update any user's info, including their roles
    }

    // If not an admin, only allow updating their own info
    return $user !== null && $currentUser->id === $user->id;
}



    public function create(User $user)
    {
        return $user->role === 'ADMIN';
    }


    public function delete(User $currentUser, User $user): bool
    {
        // Allow deleting other users but not oneself
        return $currentUser->id !== $user->id;
    }
}
