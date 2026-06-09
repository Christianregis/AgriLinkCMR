<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivateAccountNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        //
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
        return (new MailMessage)
            ->subject('AgriLinkCMR - Activation de votre compte')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre compte sur AgriLinkCMR doit être activé a travers le lien ci-dessous pour pouvoir accéder à toutes les fonctionnalités de notre plateforme.')
            ->action('Activer mon compte', url(route('activateAccount', ['email' => $notifiable->email])))
            ->line('Merci d\'avoir choisi AgriLinkCMR !')
            ->line('L\'équipe AgriLinkCMR');
    }

    /**
     * Get the array representation of the notification.
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
