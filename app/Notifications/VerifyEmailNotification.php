<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Confirmez votre email - WimoStock')
            ->greeting('Bonjour '.($notifiable->nom ?? $notifiable->name ?? ''))
            ->line('Merci de vous être inscrit sur WimoStock.')
            ->line('Veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous.')
            ->action('Confirmer mon email', $verificationUrl)
            ->line('Si vous n’avez pas créé de compte, vous pouvez ignorer cet email.')
            ->salutation('Merci, L\'équipe WimoStock');
    }
}
