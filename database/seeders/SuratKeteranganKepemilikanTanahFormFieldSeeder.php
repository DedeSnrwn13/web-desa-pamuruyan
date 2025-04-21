<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganKepemilikanTanahFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::PERNYATAAN_KEPEMILIKAN_TANAH->value)
            ->first();

        // Data Surat
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nomor_surat',
            'label' => 'Nomor Surat',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 1,
            'group' => 'Data Surat'
        ]);

        // Data Kepala Desa
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_kepala_desa',
            'label' => 'Nama Kepala Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 2,
            'group' => 'Data Kepala Desa'
        ]);

        // Data Pemohon
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_lengkap',
            'label' => 'Nama Lengkap',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik',
            'label' => 'NIK',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir',
            'label' => 'Tempat Lahir',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir',
            'label' => 'Tanggal Lahir',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'umur',
            'label' => 'Umur',
            'tipe' => 'number',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Data Pemohon'
        ]);

        // Alamat
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun',
            'label' => 'Dusun',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 9,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt',
            'label' => 'RT',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw',
            'label' => 'RW',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa',
            'label' => 'Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan',
            'label' => 'Kecamatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Alamat'
        ]);

        // Data Tanah
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'register_desa',
            'label' => 'Register Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Data Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_pernyataan',
            'label' => 'Tanggal Pernyataan',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Data Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nomor_sppt',
            'label' => 'Nomor SPPT PBB',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Data Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'luas_tanah',
            'label' => 'Luas Tanah (Ha)',
            'tipe' => 'number',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Data Tanah'
        ]);

        // Batas Tanah
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'batas_utara',
            'label' => 'Batas Sebelah Utara',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Batas Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'batas_selatan',
            'label' => 'Batas Sebelah Selatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Batas Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'batas_timur',
            'label' => 'Batas Sebelah Timur',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 20,
            'group' => 'Batas Tanah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'batas_barat',
            'label' => 'Batas Sebelah Barat',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 21,
            'group' => 'Batas Tanah'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 22,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 23,
            'group' => 'Data Pengesahan'
        ]);
    }
}