<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Category $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['instructor', 'admin']);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }
}
