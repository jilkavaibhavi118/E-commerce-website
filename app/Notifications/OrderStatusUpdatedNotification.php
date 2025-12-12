<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdatedNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
        // Email → Customer
        // Database → Admin (or customer panel)
    }

    /**
     * Email Notification (Customer)
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Order Status Has Been Updated')
            ->line('Your order #'.$this->order->id.' status is now:')
            ->line('➡ '.$this->order->status)
            ->action('View Order', url('/user/orders/'.$this->order->id))
            ->line('Thank you for shopping with us!');
    }

    /**
     * Database Notification (Admin / Customer)
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status'   => $this->order->status,
            'message'  => 'Order status has been updated to '.$this->order->status,
        ];
    }

    /**
     * Optional array format
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ];
    }
}
