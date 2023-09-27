<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use App\Support\Role;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRoleChangedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        private User $user,
        private Role $oldRole,
        private Role $newRole,
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOldRole(): Role
    {
        return $this->oldRole;
    }

    public function getNewRole(): Role
    {
        return $this->newRole;
    }
}
