<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Models\SuratFormField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuratFormFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'nama',
                'label' => 'Nama',
                'tipe' => 'text',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 1,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'tempat_lahir',
                'label' => 'Tempat Lahir',
                'tipe' => 'text',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 2,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'tanggal_lahir',
                'label' => 'Tanggal Lahir',
                'tipe' => 'date',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 3,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'jenis_kelamin',
                'label' => 'Jenis Kelamin',
                'tipe' => 'select',
                'opsi' => 'Laki-laki,Perempuan',
                'is_required' => true,
                'urutan' => 4,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'status_perkawinan',
                'label' => 'Status Perkawinan',
                'tipe' => 'select',
                'opsi' => 'Kawin,Belum Kawin,Cerai Hidup,Cerai Mati',
                'is_required' => true,
                'urutan' => 5,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'no_ktp',
                'label' => 'No. KTP/KK',
                'tipe' => 'text',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 6,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'kewarganegaraan',
                'label' => 'Kewarganegaraan',
                'tipe' => 'text',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 7,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'agama',
                'label' => 'Agama',
                'tipe' => 'select',
                'opsi' => 'Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
                'is_required' => true,
                'urutan' => 8,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'pekerjaan',
                'label' => 'Pekerjaan',
                'tipe' => 'text',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 9,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'alamat',
                'label' => 'Alamat',
                'tipe' => 'textarea',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 10,
                'group' => 'Data Diri'
            ],
            [
                'jenis_surat_id' => 1,
                'nama_field' => 'keperluan',
                'label' => 'Keperluan',
                'tipe' => 'textarea',
                'opsi' => null,
                'is_required' => true,
                'urutan' => 11,
                'group' => 'Keperluan Surat'
            ],
        ];

        foreach ($fields as $field) {
            SuratFormField::create($field);
        }
    }
}