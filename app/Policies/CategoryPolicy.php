<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Alleen beheerders mogen categorieën bekijken.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Alleen beheerders mogen categorieën aanmaken.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Alleen beheerders mogen categorieën bewerken.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Alleen beheerders mogen categorieën verwijderen.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Alleen beheerders mogen categorieën herstellen uit de prullenbak.
     */
    public function restore(User $user, Category $category): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
