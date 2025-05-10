<?php

namespace App\Repositories;

use App\Models\Jadwal;

class JadwalRepository
{
    public function getJadwalKegiatan()
    {
        return Jadwal::where('status_kegiatan', '!=', 'Dibatalkan')
            ->orderBy('waktu', 'asc')
            ->get();
    }
}