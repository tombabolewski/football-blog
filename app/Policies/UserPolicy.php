<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Support\Permission;

class UserPolicy
{
    public function register(User|null $user): bool
    {
        return true;
    }

    public function resetPassword(User $user): bool
    {
        return $user->id === auth()->user()->id;
    }

    public function login(User|null $user): bool
    {
        // Make sure the user is not already logged in;
        // We check for user permission to login later on
        // @see App\Http\Controllers\AuthenticationController@login
        return empty($subject);
    }

    public function logout(User $user): bool
    {
        return $user->id === auth()->user()->id;
    }

    // Admin functionalities
    public function viewAny(User $user): bool
    {
        return $user->can(Permission::USER_VIEW_ANY);
    }

    public function view(User $user): bool
    {
        return $user->can(Permission::USER_VIEW);
    }

    public function create(User $user): bool
    {
        return $user->can(Permission::USER_CREATE);
    }

    public function update(User $user): bool
    {
        return $user->can(Permission::USER_UPDATE);
    }

    public function delete(User $user): bool
    {
        return $user->can(Permission::USER_DELETE);
    }
}
