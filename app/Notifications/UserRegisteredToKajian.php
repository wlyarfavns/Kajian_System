<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegisteredToKajian extends Notification
{
    use Queueable;

    public $kajian;
    public $attendee;

    /**
     * Create a new notification instance.
     */
    public function __construct($kajian, $attendee)
    {
        $this->kajian = $kajian;
        $this->attendee = $attendee;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'user_registered',
            'kajian_id' => $this->kajian->id,
            'kajian_title' => $this->kajian->title,
            'attendee_name' => $this->attendee->name,
            'message' => "{$this->attendee->name} telah mendaftar untuk menghadiri kajian '{$this->kajian->title}'.",
        ];
    }
}
