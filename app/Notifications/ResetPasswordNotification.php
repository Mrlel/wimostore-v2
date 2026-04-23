<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset() ?? $notifiable->email,
        ], false));

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe - WimoStock')
            ->greeting('Bonjour '.($notifiable->nom ?? $notifiable->name ?? ''))
            ->line('Vous avez demandé à réinitialiser votre mot de passe pour votre compte WimoStock.')
            ->action('Réinitialiser mon mot de passe', $resetUrl)
            ->line('Si vous n’avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.')
            ->salutation('Merci, L\'équipe WimoStock');
    }
}
