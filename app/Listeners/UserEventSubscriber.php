<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Events\UserRoleChangedEvent;
use App\Notifications\UserCreatedNotification;
use App\Notifications\UserRoleChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserEventSubscriber
{
    public function subscribe(): array
    {
        return [
            UserCreatedEvent::class => 'handleUserCreatedEvent',
            UserRoleChangedEvent::class => 'handleUserRoleChangedEvent',
        ];
    }

    public function handleUserCreatedEvent(UserCreatedEvent $event): void
    {
        $user = $event->getUser();
        $user->notify(new UserCreatedNotification($user));
    }

    public function handleUserRoleChangedEvent(UserRoleChangedEvent $event): void
    {
        $user = $event->getUser();
        $user->notify(new UserRoleChangedNotification($user, $event->getOldRole(), $event->getNewRole()));
    }
}
