<?php

namespace App\Enum;

enum SuratStatus: string
{
    case MENUNGGU = 'menunggu';
    case DITINJAU = 'ditinjau';
    case DISETUJUI = 'disetujui';
    case DITOLAK = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::MENUNGGU => 'Menunggu',
            self::DITINJAU => 'Sedang Ditinjau',
            self::DISETUJUI => 'Disetujui',
            self::DITOLAK => 'Ditolak',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::MENUNGGU => 'warning',
            self::DITINJAU => 'info',
            self::DISETUJUI => 'success',
            self::DITOLAK => 'danger',
        };
    }
}