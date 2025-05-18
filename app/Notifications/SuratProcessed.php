<?php

namespace App\Notifications;

use App\Models\Surat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SuratProcessed extends Notification
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
        $status = $this->surat->status;
        $jenisSurat = $this->surat->jenisSurat->nama;

        if ($status === 'disetujui') {
            $message = "Surat {$jenisSurat} telah disetujui. Silakan download surat Anda.";
        } else {
            $message = "Surat {$jenisSurat} ditolak dengan alasan: {$this->surat->keterangan_admin}";
        }

        return [
            'surat_id' => $this->surat->id,
            'title' => "Status Surat Diperbarui",
            'message' => $message,
            'status' => $status
        ];
    }
}