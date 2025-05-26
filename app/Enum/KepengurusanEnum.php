<?php

namespace App\Enum;

enum KepengurusanEnum: string
{
    // Kepala Desa
    case KEPALA_DESA = 'Kepala Desa';

    // Sekretariat Desa
    case SEKRETARIS_DESA = 'Sekretaris Desa';
    case KAUR_TATA_USAHA = 'Kepala Urusan Tata Usaha dan Umum';
    case KAUR_KEUANGAN = 'Kepala Urusan Keuangan';
    case KAUR_PERENCANAAN = 'Kepala Urusan Perencanaan';

    // Pelaksana Teknis
    case KASI_PEMERINTAHAN = 'Kepala Seksi Pemerintahan';
    case KASI_KESEJAHTERAAN = 'Kepala Seksi Kesejahteraan';
    case KASI_PELAYANAN = 'Kepala Seksi Pelayanan';

    // Pelaksana Kewilayahan
    case KEPALA_DUSUN_1 = 'Kepala Dusun I';
    case KEPALA_DUSUN_2 = 'Kepala Dusun II';
    case KEPALA_DUSUN_3 = 'Kepala Dusun III';
    case KEPALA_DUSUN_4 = 'Kepala Dusun IV';

    public static function getDescription(self $value): string
    {
        return match ($value) {
            self::KEPALA_DESA => 'Merupakan pemimpin tertinggi di desa yang bertanggung jawab atas penyelenggaraan pemerintahan, pembangunan, pembinaan kemasyarakatan, dan pemberdayaan masyarakat.',

            self::SEKRETARIS_DESA => 'Memimpin sekretariat desa dan bertanggung jawab atas administrasi pemerintahan desa.',
            self::KAUR_TATA_USAHA => 'Mengelola administrasi umum dan ketatalaksanaan.',
            self::KAUR_KEUANGAN => 'Bertanggung jawab atas pengelolaan keuangan desa.',
            self::KAUR_PERENCANAAN => 'Menyusun rencana pembangunan dan kegiatan desa.',

            self::KASI_PEMERINTAHAN => 'Menangani urusan pemerintahan dan administrasi kependudukan.',
            self::KASI_KESEJAHTERAAN => 'Mengelola bidang kesejahteraan masyarakat, pendidikan, dan kesehatan.',
            self::KASI_PELAYANAN => 'Bertanggung jawab atas pelayanan publik dan sosial.',

            self::KEPALA_DUSUN_1,
            self::KEPALA_DUSUN_2,
            self::KEPALA_DUSUN_3,
            self::KEPALA_DUSUN_4 => 'Bertugas membantu Kepala Desa dalam pelaksanaan tugas di wilayahnya masing-masing.',
        };
    }

    public static function getOptions(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->value;
        }
        return $options;
    }
}