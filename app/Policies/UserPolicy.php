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

    public function update(User $currentUser, User $user): bool
    {
        return $currentUser->id === $user->id;
    }


    public function create(User $currentUser): bool
    {
        return $currentUser->isAdministrator();
    }

    public function delete(User $currentUser, User $user): bool
    {
        // อนุญาตให้ลบผู้ใช้คนอื่นได้ แต่ไม่อนุญาตให้ลบตัวเอง
        return $currentUser->id !== $user->id;
    }
}
