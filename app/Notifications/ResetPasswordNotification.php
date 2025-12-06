<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     */
    public string $token;

    /**
     * The token expiry time in minutes.
     */
    protected int $expireMinutes;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
        $this->expireMinutes = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);
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
        // Build the reset URL for your frontend app
        $frontendUrl = config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:5173'));
        $resetUrl = $frontendUrl . '/reset-password?token=' . $this->token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());

        return (new MailMessage)
            ->subject('Reset Your Password - Budget Tracker')
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . '!')
            ->line('You are receiving this email because we received a password reset request for your Budget Tracker account.')
            ->line('Click the button below to reset your password:')
            ->action('Reset Password', $resetUrl)
            ->line('This password reset link will expire in ' . $this->expireMinutes . ' minutes.')
            ->line('**Security Tips:**')
            ->line('• If you did not request this reset, please ignore this email.')
            ->line('• Never share your password with anyone.')
            ->line('• Use a strong, unique password for your account.')
            ->salutation('Best regards,' . "\n" . 'The Budget Tracker Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
