<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSurats = [
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Pengantar RT dan RW',
                'kode' => 'SK-RT/RW'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Ahli Waris',
                'kode' => 'SK-AW'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Ahli Waris untuk Bank',
                'kode' => 'SK-AWB'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Usaha',
                'kode' => 'SK-U'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Beda Nama',
                'kode' => 'SK-BN'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Kematian',
                'kode' => 'SK-KM'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Catatan Kepolisian [SKCK]',
                'kode' => 'SKCK'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Tidak Mampu [Beasiswa]',
                'kode' => 'SKTM-B'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Kehilangan Akta Cerai',
                'kode' => 'SK-KAC'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Belum Kawin',
                'kode' => 'SK-BK'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Pernyataan Kepemilikan Tanah',
                'kode' => 'SP-KT'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Keterangan Domisili',
                'kode' => 'SK-D'
            ],
        ];

        foreach ($jenisSurats as $jenisSurat) {
            JenisSurat::create($jenisSurat);
        }
    }
}