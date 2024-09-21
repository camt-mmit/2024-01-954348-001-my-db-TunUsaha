<?php
// app/Policies/ShopPolicy.php
namespace App\Policies;

use App\Models\User;

class ShopPolicy
{
    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function delete(User $user): bool
    {
        return $user->isAdministrator();
    }
}
