<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewKajianSubmitted extends Notification
{
    use Queueable;

    public $kajian;
    public $organizer;

    public function __construct($kajian, $organizer)
    {
        $this->kajian = $kajian;
        $this->organizer = $organizer;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_kajian_submitted',
            'kajian_id' => $this->kajian->id,
            'kajian_title' => $this->kajian->title,
            'organizer_name' => $this->organizer->name,
            'message' => "Penyelenggara '{$this->organizer->name}' telah menambahkan kajian baru '{$this->kajian->title}' dan menunggu verifikasi.",
            'action_url' => url('/admin/kajian'),
        ];
    }
}
