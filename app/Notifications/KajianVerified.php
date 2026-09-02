<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KajianVerified extends Notification
{
    use Queueable;

    public $kajian;

    public function __construct($kajian)
    {
        $this->kajian = $kajian;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'kajian_verified',
            'kajian_id' => $this->kajian->id,
            'kajian_title' => $this->kajian->title,
            'message' => "Kajian Anda '{$this->kajian->title}' telah berhasil diverifikasi dan sekarang dapat dilihat secara publik.",
            'action_url' => url('/organizer/kajian'),
        ];
    }
}
