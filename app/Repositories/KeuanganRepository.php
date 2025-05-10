<?php

namespace App\Repositories;

use App\Models\Keuangan;

class KeuanganRepository
{
    public function getTotalPendapatan()
    {
        return Keuangan::where('kategori_anggaran', 'Pendapatan')
            ->where('status', 'Validasi')
            ->sum('nominal');
    }

    public function getTotalBelanja()
    {
        return Keuangan::where('kategori_anggaran', 'Belanja')
            ->where('status', 'Validasi')
            ->sum('nominal');
    }

    public function getTotalPembiayaan()
    {
        return Keuangan::where('kategori_anggaran', 'Pembiayaan')
            ->where('status', 'Validasi')
            ->sum('nominal');
    }

    public function getSumberPendapatan()
    {
        return Keuangan::where('kategori_anggaran', 'Pendapatan')
            ->where('status', 'Validasi')
            ->select('sumber_dana', 'nominal')
            ->get()
            ->groupBy('sumber_dana')
            ->map(function ($row) {
                return $row->sum('nominal');
            });
    }

    public function getJenisBelanja()
    {
        return Keuangan::where('kategori_anggaran', 'Belanja')
            ->where('status', 'Validasi')
            ->select('sub_kategori', 'nominal')
            ->get()
            ->groupBy('sub_kategori')
            ->map(function ($row) {
                return $row->sum('nominal');
            });
    }

    public function getJenisPembiayaan()
    {
        return Keuangan::where('kategori_anggaran', 'Pembiayaan')
            ->where('status', 'Validasi')
            ->select('sub_kategori', 'nominal')
            ->get()
            ->groupBy('sub_kategori')
            ->map(function ($row) {
                return $row->sum('nominal');
            });
    }
}