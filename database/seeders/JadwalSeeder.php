<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JadwalSeeder extends Seeder
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
                'nama_kegiatan' => 'Musyawarah Desa',
                'waktu' => now()->addDays(7)->setHour(9)->setMinute(0),
                'waktu_selesai' => now()->addDays(7)->setHour(12)->setMinute(0),
                'lokasi' => 'Balai Desa Pamuruyan',
                'deskripsi' => 'Musyawarah pembahasan program pembangunan desa tahun 2024',
                'status_kegiatan' => 'Belum Dimulai',
                'penanggung_jawab' => 'Kepala Desa',
                'jumlah_peserta' => 50,
                'anggaran' => 2500000,
                'keterangan_tambahan' => 'Dihadiri oleh perangkat desa dan tokoh masyarakat',
            ],
            [
                'admin_id' => $admin->id,
                'nama_kegiatan' => 'Gotong Royong',
                'waktu' => now()->addDays(3)->setHour(7)->setMinute(0),
                'waktu_selesai' => now()->addDays(3)->setHour(10)->setMinute(0),
                'lokasi' => 'RT 01/RW 02',
                'deskripsi' => 'Kerja bakti membersihkan lingkungan dan selokan',
                'status_kegiatan' => 'Belum Dimulai',
                'penanggung_jawab' => 'Ketua RT',
                'jumlah_peserta' => 30,
                'anggaran' => 500000,
                'keterangan_tambahan' => 'Membawa peralatan kebersihan masing-masing',
            ],
            [
                'admin_id' => $admin->id,
                'nama_kegiatan' => 'Posyandu Balita',
                'waktu' => now()->addDays(14)->setHour(8)->setMinute(0),
                'waktu_selesai' => now()->addDays(14)->setHour(11)->setMinute(0),
                'lokasi' => 'Posyandu Desa',
                'deskripsi' => 'Pemeriksaan kesehatan rutin balita dan pemberian vitamin',
                'status_kegiatan' => 'Belum Dimulai',
                'penanggung_jawab' => 'Bidan Desa',
                'jumlah_peserta' => 25,
                'anggaran' => 1000000,
                'keterangan_tambahan' => 'Membawa KMS dan buku kesehatan anak',
            ],
            [
                'admin_id' => $admin->id,
                'nama_kegiatan' => 'Pelatihan UMKM',
                'waktu' => now()->addDays(10)->setHour(13)->setMinute(0),
                'waktu_selesai' => now()->addDays(10)->setHour(16)->setMinute(0),
                'lokasi' => 'Aula Desa',
                'deskripsi' => 'Pelatihan pembuatan produk dan pemasaran digital',
                'status_kegiatan' => 'Belum Dimulai',
                'penanggung_jawab' => 'Kasi Kesejahteraan',
                'jumlah_peserta' => 35,
                'anggaran' => 3000000,
                'keterangan_tambahan' => 'Peserta membawa laptop atau smartphone',
            ],
            [
                'admin_id' => $admin->id,
                'nama_kegiatan' => 'Rapat PKK',
                'waktu' => now()->addDays(5)->setHour(14)->setMinute(0),
                'waktu_selesai' => now()->addDays(5)->setHour(16)->setMinute(0),
                'lokasi' => 'Balai Desa Pamuruyan',
                'deskripsi' => 'Rapat koordinasi program PKK bulan ini',
                'status_kegiatan' => 'Belum Dimulai',
                'penanggung_jawab' => 'Ketua PKK',
                'jumlah_peserta' => 20,
                'anggaran' => 750000,
                'keterangan_tambahan' => 'Membawa laporan kegiatan masing-masing pokja',
            ],
        ];

        foreach ($data as $item) Jadwal::create($item);
    }
} 