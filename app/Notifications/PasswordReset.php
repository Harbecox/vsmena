<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable;

    public string $token;
    /**
     * Create a new notification instance.
     */
    public function __construct($token) {
        $this->token = $token;
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
    public function toMail($notifiable) {
        return (new MailMessage)
            ->greeting("Уважаемый пользователь!")
            ->line("Вы получили это письмо, поскольку произвели процедуру " .
                "сброса пароля.")
            ->action("Сбросить пароль", url("password/reset", $this->token))
            ->line("Если вы не выполняли сброс пароля, ничего не " .
                "предпринимайте.")
            ->from("mail@a0567276.xsph.ru", "Администрация");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
