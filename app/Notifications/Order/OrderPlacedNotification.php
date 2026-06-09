<?php

namespace App\Notifications\Order;

use App\enum\UserRole;
use App\Models\Order;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order
    ) { //
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
        if ($this->order->farmer->role === UserRole::FARMER->value) {
            return (new MailMessage)
                ->subject('Nouvelle commande reçue')
                ->greeting('Bonjour ' . $notifiable->name . ',')
                ->line('Vous avez reçu une nouvelle commande de la part de ' . $this->order->buyer->user->name . '.')
                ->line('Prix total : ' . $this->order->total_amount . ' FCFA')
                ->action('Voir la commande', url(route('farmerOrderView', ['order_id' => $this->order->id])))
                ->line('Merci d\'utiliser notre application !')
                ->line('L\'équipe AgriLinkCMR');
        } else {
            return (new MailMessage)
                ->subject('Votre commande a été passée avec succès !')
                ->greeting('Bonjour ' . $notifiable->name . ',')
                ->line('Prix total : ' . $this->order->total_amount . ' FCFA')
                ->action('Voir la commande', url(route('buyerOrderTracking', ['order_id' => $this->order->id])))
                ->line('Merci d\'avoir utilisé notre application !')
                ->line('L\'équipe AgriLinkCMR');
        }
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
