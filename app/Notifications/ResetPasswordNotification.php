<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly string $token)
    {
    }

    /**
     * Get the notification channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = URL::route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);

        return (new MailMessage)
            ->subject('Reset your iSTaksyon password')
            ->view('emails.password_reset', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'expireMinutes' => config('auth.passwords.users.expire', 60),
            ]);
    }
}
