<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KajianRejected extends Notification
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
            'type' => 'kajian_rejected',
            'kajian_id' => $this->kajian->id,
            'kajian_title' => $this->kajian->title,
            'message' => "Kajian Anda '{$this->kajian->title}' telah ditolak/dibatalkan oleh Admin. Silakan hubungi admin untuk info lebih lanjut.",
            'action_url' => url('/organizer/kajian'),
        ];
    }
}
