<?php

namespace App\Enum;

enum KeuanganStatusEnum: string
{
    case VALIDASI = 'Validasi';
    case BELUM_VALIDASI = 'Belum Validasi';
}