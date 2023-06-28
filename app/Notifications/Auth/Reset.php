<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class Reset extends ResetPassword
{
    private string $name;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     */
    public function __construct(string $token, string $name)
    {
        parent::__construct($token);
        $this->name = $name;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(trans('mail.greeting') . ' ' . $this->name)
            ->line(trans('auth.notification.message_1'))
            ->action(trans('auth.notification.button'), url('auth/reset', $this->token))
            ->line(trans('auth.notification.message_2'));
    }
}
