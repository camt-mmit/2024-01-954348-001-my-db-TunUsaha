<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // in class body
    function create(User $user): bool
    {
        // Same as update policy, we consider create is a special case of update.
        return $this->update($user);
    }
function update(User $user): bool {
    return $user->isAdministrator();
    }
    function delete(User $user, Category $category): bool {
    // to make sure there is products_count.
    $category->loadCount('products');
    return $this->update($user) && ($category->products_count === 0);
    }
}
