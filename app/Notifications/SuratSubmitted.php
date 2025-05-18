<?php

namespace App\Notifications;

use App\Models\Surat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SuratSubmitted extends Notification
{
    use Queueable;

    public function __construct(
        public Surat $surat
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'surat_id' => $this->surat->id,
            'title' => 'Pengajuan Surat Baru',
            'message' => "Surat {$this->surat->jenisSurat->nama} telah diajukan oleh {$this->surat->warga->nama}",
            'status' => 'menunggu'
        ];
    }
}