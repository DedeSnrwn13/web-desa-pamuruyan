<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganDomisiliFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_DOMISILI->value)
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
            'label' => 'Nama',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 2,
            'group' => 'Data Kepala Desa'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jabatan',
            'label' => 'Jabatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Data Kepala Desa'
        ]);

        // Data Pemohon
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama',
            'label' => 'Nama',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik',
            'label' => 'NIK',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir',
            'label' => 'Tempat Lahir',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir',
            'label' => 'Tanggal Lahir',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'status_perkawinan',
            'label' => 'Status Perkawinan',
            'tipe' => 'select',
            'opsi' => 'Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'agama',
            'label' => 'Agama',
            'tipe' => 'select',
            'opsi' => 'Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'is_required' => true,
            'urutan' => 9,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_pemohon',
            'label' => 'Tanda Tangan Pemohon',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Data Pemohon'
        ]);

        // Alamat
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun',
            'label' => 'Dusun',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt',
            'label' => 'RT',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw',
            'label' => 'RW',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa',
            'label' => 'Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Alamat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan',
            'label' => 'Kecamatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Alamat'
        ]);

        // Tujuan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tujuan_domisili',
            'label' => 'Tujuan Keterangan Domisili',
            'tipe' => 'textarea',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Data Tujuan'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Data Pengesahan'
        ]);
    }
}