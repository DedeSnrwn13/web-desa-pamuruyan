<?php

namespace Database\Seeders;

use App\Models\KategoriBerita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'admin_id' => 1,
                'nama' => 'Berita Desa',
                'slug' => 'berita-desa',
                'deskripsi' => 'Informasi terkini seputar kegiatan dan perkembangan desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Pembangunan',
                'slug' => 'pembangunan',
                'deskripsi' => 'Informasi tentang pembangunan infrastruktur dan fasilitas desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Program Desa',
                'slug' => 'program-desa',
                'deskripsi' => 'Program-program yang sedang dan akan dilaksanakan oleh desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Ekonomi',
                'slug' => 'ekonomi',
                'deskripsi' => 'Berita seputar ekonomi dan UMKM desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Kesehatan',
                'slug' => 'kesehatan',
                'deskripsi' => 'Informasi kesehatan dan kegiatan posyandu desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Pendidikan',
                'slug' => 'pendidikan',
                'deskripsi' => 'Berita seputar pendidikan dan kegiatan belajar di desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Sosial & Budaya',
                'slug' => 'sosial-budaya',
                'deskripsi' => 'Kegiatan sosial dan pelestarian budaya desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Pertanian',
                'slug' => 'pertanian',
                'deskripsi' => 'Informasi seputar pertanian dan hasil bumi desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Lingkungan',
                'slug' => 'lingkungan',
                'deskripsi' => 'Berita tentang lingkungan dan kebersihan desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keamanan',
                'slug' => 'keamanan',
                'deskripsi' => 'Informasi keamanan dan ketertiban desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Kepemudaan',
                'slug' => 'kepemudaan',
                'deskripsi' => 'Kegiatan karang taruna dan organisasi pemuda desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'PKK',
                'slug' => 'pkk',
                'deskripsi' => 'Kegiatan dan program PKK desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'BPD',
                'slug' => 'bpd',
                'deskripsi' => 'Informasi dari Badan Permusyawaratan Desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Bumdes',
                'slug' => 'bumdes',
                'deskripsi' => 'Kegiatan dan perkembangan Badan Usaha Milik Desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Pengumuman',
                'slug' => 'pengumuman',
                'deskripsi' => 'Pengumuman dan informasi penting dari pemerintah desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Agenda',
                'slug' => 'agenda',
                'deskripsi' => 'Jadwal kegiatan dan acara yang akan dilaksanakan di desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Galeri',
                'slug' => 'galeri',
                'deskripsi' => 'Dokumentasi kegiatan dan foto-foto desa'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Transparansi',
                'slug' => 'transparansi',
                'deskripsi' => 'Informasi transparansi anggaran dan keuangan desa'
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBerita::create($kategori);
        }
    }
}