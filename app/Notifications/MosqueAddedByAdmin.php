<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MosqueAddedByAdmin extends Notification
{
    use Queueable;

    public $mosque;

    /**
     * Create a new notification instance.
     */
    public function __construct($mosque)
    {
        $this->mosque = $mosque;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'mosque_added',
            'mosque_id' => $this->mosque->id,
            'mosque_name' => $this->mosque->name,
            'message' => "Admin telah menambahkan masjid '{$this->mosque->name}' ke dalam daftar Anda.",
        ];
    }
}
