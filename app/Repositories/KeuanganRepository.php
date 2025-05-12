<?php

namespace App\Repositories;

use App\Models\Keuangan;
use App\Enum\KeuanganStatusEnum;
use App\Enum\KategoriAnggaranEnum;
use Illuminate\Support\Facades\DB;

class KeuanganRepository
{
    public function getTotalPendapatan($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::PENDAPATAN->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }
    
        return $query->sum('nominal');
    }

    public function getTotalBelanja($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::BELANJA->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->sum('nominal');
    }

    public function getTotalPembiayaan($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::PEMBIAYAAN->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->sum('nominal');
    }

    public function getSumberPendapatan($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::PENDAPATAN->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->select('sumber_dana', DB::raw('SUM(nominal) as total'))
            ->groupBy('sumber_dana')
            ->pluck('total', 'sumber_dana');
    }

    public function getJenisBelanja($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::BELANJA->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->select('sub_kategori', DB::raw('SUM(nominal) as total'))
            ->groupBy('sub_kategori')
            ->pluck('total', 'sub_kategori');
    }

    public function getJenisPembiayaan($tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', KategoriAnggaranEnum::PEMBIAYAAN->value)
            ->where('status', KeuanganStatusEnum::VALIDASI->value);
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->select('sub_kategori', DB::raw('SUM(nominal) as total'))
            ->groupBy('sub_kategori')
            ->pluck('total', 'sub_kategori');
    }

    public function getProgramDetails($kategori, $tahun = null)
    {
        $query = Keuangan::where('kategori_anggaran', $kategori)
            ->where('status', KeuanganStatusEnum::VALIDASI->value)
            ->select(
                'nama_program',
                'sub_kategori',
                'pagu_anggaran',
                'realisasi_anggaran',
                'persentase_realisasi',
                'status_realisasi',
                'keterangan'
            );
            
        if ($tahun) {
            $query->where('tahun_anggaran', $tahun);
        }

        return $query->orderBy('nama_program')->get();
    }

    public function getAvailableYears()
    {
        return Keuangan::select('tahun_anggaran')
            ->distinct()
            ->whereNotNull('tahun_anggaran')
            ->orderBy('tahun_anggaran', 'desc')
            ->pluck('tahun_anggaran');
    }
}