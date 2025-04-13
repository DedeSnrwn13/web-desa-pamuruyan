<?php

namespace App\Enum;

enum JenisSuratEnum: string
{
    case PENGANTAR_RT_RW = 'SK-RT/RW';
    case KETERANGAN_AHLI_WARIS = 'SK-AW';
    case KETERANGAN_AHLI_WARIS_BANK = 'SK-AWB';
    case KETERANGAN_USAHA = 'SK-U';
    case KETERANGAN_BEDA_NAMA = 'SK-BN';
    case KETERANGAN_KEMATIAN = 'SK-KM';
    case KETERANGAN_CATATAN_KEPOLISIAN = 'SKCK';
    case KETERANGAN_TIDAK_MAMPU_BEASISWA = 'SKTM-B';
    case KETERANGAN_KEHILANGAN_AKTA_CERAI = 'SK-KAC';
    case KETERANGAN_BELUM_KAWIN = 'SK-BK';
    case PERNYATAAN_KEPEMILIKAN_TANAH = 'SP-KT';
    case KETERANGAN_DOMISILI = 'SK-D';

    public function label(): string
    {
        return match($this) {
            self::PENGANTAR_RT_RW => 'Keterangan Pengantar RT dan RW',
            self::KETERANGAN_AHLI_WARIS => 'Keterangan Ahli Waris',
            self::KETERANGAN_AHLI_WARIS_BANK => 'Keterangan Ahli Waris untuk Bank',
            self::KETERANGAN_USAHA => 'Keterangan Usaha',
            self::KETERANGAN_BEDA_NAMA => 'Keterangan Beda Nama',
            self::KETERANGAN_KEMATIAN => 'Keterangan Kematian',
            self::KETERANGAN_CATATAN_KEPOLISIAN => 'Keterangan Catatan Kepolisian [SKCK]',
            self::KETERANGAN_TIDAK_MAMPU_BEASISWA => 'Keterangan Tidak Mampu [Beasiswa]',
            self::KETERANGAN_KEHILANGAN_AKTA_CERAI => 'Keterangan Kehilangan Akta Cerai',
            self::KETERANGAN_BELUM_KAWIN => 'Keterangan Belum Kawin',
            self::PERNYATAAN_KEPEMILIKAN_TANAH => 'Pernyataan Kepemilikan Tanah',
            self::KETERANGAN_DOMISILI => 'Keterangan Domisili',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }
}