<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Keuangan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();

        if (!$admin) {
            $this->command->error('Admin not found. Please run AdminSeeder first.');
            return;
        }

        $data = [
            [
                'admin_id' => $admin->id,
                'sumber_dana' => 'Dana Desa',
                'nominal' => 100000000,
                'jenis_transaksi' => 'Pemasukan',
                'keterangan' => 'Dana Desa Tahap 1',
                'tanggal_transaksi' => now(),
                'status' => 'Validasi',
                'tahun_anggaran' => 2024,
                'nama_program' => 'Program Pembangunan Desa',
                'kategori_anggaran' => 'Pendapatan',
                'sub_kategori' => 'Dana Transfer',
                'pagu_anggaran' => 500000000,
                'realisasi_anggaran' => 100000000,
                'persentase_realisasi' => 20.00,
                'status_realisasi' => 'Sedang Berjalan',
            ],
            [
                'admin_id' => $admin->id,
                'sumber_dana' => 'Bantuan Pemerintah',
                'nominal' => 50000000,
                'jenis_transaksi' => 'Pemasukan',
                'keterangan' => 'Bantuan Dana BOS',
                'tanggal_transaksi' => now(),
                'status' => 'Validasi',
                'tahun_anggaran' => 2024,
                'nama_program' => 'Program Pendidikan',
                'kategori_anggaran' => 'Pendapatan',
                'sub_kategori' => 'Bantuan Pemerintah',
                'pagu_anggaran' => 100000000,
                'realisasi_anggaran' => 50000000,
                'persentase_realisasi' => 50.00,
                'status_realisasi' => 'Sedang Berjalan',
            ],
            [
                'admin_id' => $admin->id,
                'sumber_dana' => 'Operasional',
                'nominal' => 5000000,
                'jenis_transaksi' => 'Pengeluaran',
                'keterangan' => 'Pembelian ATK',
                'tanggal_transaksi' => now(),
                'status' => 'Validasi',
                'tahun_anggaran' => 2024,
                'nama_program' => 'Program Administrasi',
                'kategori_anggaran' => 'Belanja',
                'sub_kategori' => 'Operasional',
                'pagu_anggaran' => 10000000,
                'realisasi_anggaran' => 5000000,
                'persentase_realisasi' => 50.00,
                'status_realisasi' => 'Selesai',
            ],
            [
                'admin_id' => $admin->id,
                'sumber_dana' => 'Pembangunan',
                'nominal' => 25000000,
                'jenis_transaksi' => 'Pengeluaran',
                'keterangan' => 'Pembangunan Jalan Desa',
                'tanggal_transaksi' => now(),
                'status' => 'Belum Validasi',
                'tahun_anggaran' => 2024,
                'nama_program' => 'Program Infrastruktur',
                'kategori_anggaran' => 'Belanja',
                'sub_kategori' => 'Pembangunan',
                'pagu_anggaran' => 100000000,
                'realisasi_anggaran' => 25000000,
                'persentase_realisasi' => 25.00,
                'status_realisasi' => 'Sedang Berjalan',
            ],
            [
                'admin_id' => $admin->id,
                'sumber_dana' => 'Investasi',
                'nominal' => 75000000,
                'jenis_transaksi' => 'Pemasukan',
                'keterangan' => 'Investasi dari Swasta',
                'tanggal_transaksi' => now(),
                'status' => 'Validasi',
                'tahun_anggaran' => 2024,
                'nama_program' => 'Program Pengembangan UMKM',
                'kategori_anggaran' => 'Pembiayaan',
                'sub_kategori' => 'Investasi',
                'pagu_anggaran' => 200000000,
                'realisasi_anggaran' => 75000000,
                'persentase_realisasi' => 37.50,
                'status_realisasi' => 'Sedang Berjalan',
            ],
        ];

        foreach ($data as $item) Keuangan::create($item);
        
    }
} 