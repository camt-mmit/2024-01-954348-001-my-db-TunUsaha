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

    function update(User $user): bool
    {
        return $user->isAdministrator();
    }
    function create(User $user): bool
    {
        // Same as update policy, we consider create is a special case of update.
        return $this->update($user);
    }
    public function delete(User $currentUser, User $user): bool
{
    // อนุญาตให้ลบผู้ใช้คนอื่นได้ แต่ไม่อนุญาตให้ลบตัวเอง
    return $currentUser->id !== $user->id;
}

}
