<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Vacancy;
use App\Models\User;

class VacancyPolicy {

 /**
     * If user is Admin, authorise all actions
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->role == Role::ADMIN ? true : null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific vacancy.
     */
    public function view(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create a vacancy.
     */
    public function create(User $user): bool
    {
        return $user->role == Role::AUTHOR;
    }

    /**
     * Determine whether the user can update a vacancy.
     */
    public function update(User $user): bool
    {
        return $user->role == Role::AUTHOR;
    }

    public function edit(User $user): bool
    {
        return $user->role == Role::AUTHOR;
    }

    /**
     * Determine whether the user can delete the vacancy.
     */
    public function delete(User $user): bool
    {
        return $user->role == Role::AUTHOR;
    }

    /**
     * Determine whether the user can restore the vacancy.
     */
    public function restore(User $user): bool
    {
        return $user->role == Role::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the vacancy.
     */
    public function forceDelete(User $user): bool
    {
        return $user->role == Role::ADMIN;
    }
}
