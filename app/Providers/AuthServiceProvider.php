<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Implicitly grant Admin role all permissions
        Gate::before(fn ($user, $ability) => $user->hasRole(Role::ADMIN->value) ? true : null);
    }
}
