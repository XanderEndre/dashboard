<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateWarehouseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $warehouse;


    /**
     * Create a new notification instance.
     */
    public function __construct($warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable) : array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable) : MailMessage
    {
        return (new MailMessage)
            ->line(auth()->user()->name . ', A new warehouse has been successfully created.')
            ->action('View Warehouse', url('/path-to-warehouse'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable) : array
    {
        return [
            //
        ];
    }
}
