<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function register(): bool
    {
        return true;
    }

    public function resetPassword(User $subject, User $object): bool
    {
        return $subject->can('reset-password') || $subject->id === $object->id;
    }

    public function login(User|null $subject): bool 
    {
        return empty($subject) || ($subject instanceof User && $subject->can('mock-user'));
    }

    public function logout(User $subject, User $object): bool 
    {
        return $subject->can('logout-user') || $subject->id === $object->id;
    }
}
