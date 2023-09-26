<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use App\Support\Permission;

class PostPolicy
{
    public function viewAny(User|null $user): bool
    {
        return true;
    }

    public function view(User|null $user, Post $post): bool
    {
        return $user->can(Permission::POST_VIEW->value);
    }

    public function create(User $user): bool
    {
        return $user->can(Permission::POST_CREATE->value);
    }

    public function update(User $user, Post $post): bool
    {
        return $user->can(Permission::POST_UPDATE->value);
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->can(Permission::POST_DELETE->value);
    }
}
