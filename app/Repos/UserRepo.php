<?php

namespace App\Repos;

use App\Events\UserCreatedEvent;
use App\Models\User;
use App\Support\Role;

class UserRepo extends BaseRepo
{
    protected static readonly string $model = User::class;

    protected function afterCreate(User $user): void
    {
        $user->syncRoles(Role::USER->value);
        dispatch(new UserCreatedEvent($user));
    }
}
