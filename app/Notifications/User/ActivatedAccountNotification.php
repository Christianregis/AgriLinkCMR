<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivatedAccountNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
            ->subject('AgriLinkCMR - Votre compte a été activé')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Nous sommes heureux de vous informer que votre compte sur AgriLinkCMR a été activé avec succès. Vous pouvez maintenant accéder à toutes les fonctionnalités de notre plateforme et commencer à explorer les produits agricoles disponibles.')
            ->line('Merci d\'avoir choisi AgriLinkCMR !')
            ->line('L\'équipe AgriLinkCMR');
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
