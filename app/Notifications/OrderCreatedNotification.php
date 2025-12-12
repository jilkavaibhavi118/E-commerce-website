<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order; 

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order; // STORE ORDER MODEL
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Email Notification
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Order Has Been Placed')
            ->line('Thank you for your order.')
            ->action('View Order', url('/user/orders/'.$this->order->id));
    }

    /**
     * Database Notification
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'A new order has been placed.',
            'amount' => $this->order->total_amount ?? $this->order->price
        ];
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
