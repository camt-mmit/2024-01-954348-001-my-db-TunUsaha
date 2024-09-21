<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // in class body
    function update(User $user): bool
    {
        return $user->isAdministrator();
    }
    function create(User $user): bool
    {
        // Same as update policy, we consider create is a special case of update.
        return $this->update($user);
    }
    function delete(User $user): bool
    {
        // Same as update policy, we consider delete is a special case of update.
        return $this->update($user);
    }
}
