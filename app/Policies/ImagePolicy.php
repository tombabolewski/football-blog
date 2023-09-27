<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use App\Support\Permission;
use Illuminate\Auth\Access\Response;

class ImagePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Image $image): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(Permission::IMAGE_CREATE->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Image $image): bool
    {
        return $user->can(Permission::IMAGE_DELETE->value);
    }
}
