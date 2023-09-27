<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use App\Support\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRoleChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private User $user,
        private Role $oldRole,
        private Role $newRole,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $oldRole = $this->oldRole->getHumanReadableName();
        $newRole = $this->newRole->getHumanReadableName();
        $hasUserBeenActivated = $this->oldRole === Role::USER;
        $mail = (new MailMessage())->line("The administrator has changed your role from {$oldRole} to {$newRole}");
        if ($hasUserBeenActivated) {
            $mail->line('Your account has been approved and you can now log in!');
        }
        return $mail->action('Visit our blog now!', url('/'))
            ->line('Thank you for using our blog!');
    }
}
