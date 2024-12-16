<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class ApplicationPolicy
{

    // TODO: reevaluate all of the policies to check if they're correct

    
    /**
     * Determine whether the user is an admin and authorise all actions
     */
    public function before(User $user, string $ability): bool|null
    {
        return $user->role == Role::ADMIN ? true : null;
    }

    /**
     * Determine whether the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        // only admins and authors can view submitted applications
        return $user->role == Role::ADMIN || $user->role == Role::AUTHOR;
    }

    /**
     * Determine whether the user can view an application.
     */
    public function view(User $user): bool
    {
        // everyone but a guest can view a vacancy's application form
        return $user->role != Role::GUEST;
    }

    /**
     * Determine whether the user can make an application.
     */
    public function create(User $user): bool
    {
        return $user->role == Role::ACCOUNT_HOLDER;
    }

    /**
     * Determine whether the user can delete the application.
     */
    public function delete(User $user): bool
    {
        return $user->role == Role::ADMIN || $user->role == Role::AUTHOR;
    }
}
