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
        $this->switchRole($user, Role::USER);
        dispatch(new UserCreatedEvent($user));
    }
}
