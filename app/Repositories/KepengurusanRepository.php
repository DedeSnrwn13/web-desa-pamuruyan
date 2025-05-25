<?php

namespace App\Repositories;

use App\Models\Kepengurusan;
use App\Enum\KepengurusanEnum;

class KepengurusanRepository
{
    public function getActivePengurus()
    {
        return Kepengurusan::where('status_aktif', true)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Kepala Desa
    public function getKepalaDesa()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KEPALA_DESA->value)
            ->first();
    }

    // Sekretariat Desa
    public function getSekretarisDesa()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::SEKRETARIS_DESA->value)
            ->first();
    }

    public function getKaurTataUsaha()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KAUR_TATA_USAHA->value)
            ->first();
    }

    public function getKaurKeuangan()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KAUR_KEUANGAN->value)
            ->first();
    }

    public function getKaurPerencanaan()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KAUR_PERENCANAAN->value)
            ->first();
    }

    // Pelaksana Teknis
    public function getKasiPemerintahan()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KASI_PEMERINTAHAN->value)
            ->first();
    }

    public function getKasiKesejahteraan()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KASI_KESEJAHTERAAN->value)
            ->first();
    }

    public function getKasiPelayanan()
    {
        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', KepengurusanEnum::KASI_PELAYANAN->value)
            ->first();
    }

    // Pelaksana Kewilayahan
    public function getKepalaDusun($number)
    {
        $dusunEnum = match ($number) {
            1 => KepengurusanEnum::KEPALA_DUSUN_1,
            2 => KepengurusanEnum::KEPALA_DUSUN_2,
            3 => KepengurusanEnum::KEPALA_DUSUN_3,
            4 => KepengurusanEnum::KEPALA_DUSUN_4,
            default => null,
        };

        if (!$dusunEnum) {
            return null;
        }

        return Kepengurusan::where('status_aktif', true)
            ->where('jabatan', $dusunEnum->value)
            ->first();
    }

    public function getAllKepalaDusun()
    {
        return Kepengurusan::where('status_aktif', true)
            ->whereIn('jabatan', [
                KepengurusanEnum::KEPALA_DUSUN_1->value,
                KepengurusanEnum::KEPALA_DUSUN_2->value,
                KepengurusanEnum::KEPALA_DUSUN_3->value,
                KepengurusanEnum::KEPALA_DUSUN_4->value,
            ])
            ->orderBy('jabatan')
            ->get();
    }

    // Get by Category
    public function getSekretariatDesa()
    {
        return Kepengurusan::where('status_aktif', true)
            ->whereIn('jabatan', [
                KepengurusanEnum::SEKRETARIS_DESA->value,
                KepengurusanEnum::KAUR_TATA_USAHA->value,
                KepengurusanEnum::KAUR_KEUANGAN->value,
                KepengurusanEnum::KAUR_PERENCANAAN->value,
            ])
            ->orderBy('jabatan')
            ->get();
    }

    public function getPelaksanaTeknis()
    {
        return Kepengurusan::where('status_aktif', true)
            ->whereIn('jabatan', [
                KepengurusanEnum::KASI_PEMERINTAHAN->value,
                KepengurusanEnum::KASI_KESEJAHTERAAN->value,
                KepengurusanEnum::KASI_PELAYANAN->value,
            ])
            ->orderBy('jabatan')
            ->get();
    }
}