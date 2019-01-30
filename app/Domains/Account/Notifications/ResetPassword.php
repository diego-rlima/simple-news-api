<?php

namespace App\Domains\Account\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    /**
     * Create a notification instance.
     *
     * @param  string  $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token, $this->url);
        }

        return (new MailMessage)
            ->subject('Redefinição de senha')
            ->line('Você está recebendo este email porque uma redefinição de senha foi solicitada para esta conta.')
            ->action('Alterar senha', frontend_url('/auth/password/reset/' . $this->token))
            ->line('Se não foi você quem solicitou a redefinição de senha, apenas ignore este email. Entre em contato com o administrador caso continue recebendo este email.');
    }
}
