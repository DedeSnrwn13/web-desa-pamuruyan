<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganCatatanKepolisianFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_CATATAN_KEPOLISIAN->value)
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
            'nama_field' => 'kebangsaan',
            'label' => 'Kebangsaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'agama',
            'label' => 'Agama',
            'tipe' => 'select',
            'opsi' => 'Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin',
            'label' => 'Jenis Kelamin',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 9,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'status_perkawinan',
            'label' => 'Status Perkawinan',
            'tipe' => 'select',
            'opsi' => 'Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pendidikan_terakhir',
            'label' => 'Pendidikan Terakhir',
            'tipe' => 'select',
            'opsi' => 'SD,SMP,SMA/SMK,D1,D2,D3,D4,S1,S2,S3',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_pemohon',
            'label' => 'Tanda Tangan Pemohon',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Data Pemohon'
        ]);

        // Alamat Pemohon
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun',
            'label' => 'Dusun',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Alamat Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt',
            'label' => 'RT',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Alamat Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw',
            'label' => 'RW',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Alamat Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa',
            'label' => 'Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Alamat Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan',
            'label' => 'Kecamatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Alamat Pemohon'
        ]);

        // Data Orang Tua/Ayah
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_ayah',
            'label' => 'Nama Orang Tua/Ayah',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Data Ayah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir_ayah',
            'label' => 'Tempat Lahir Ayah',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 20,
            'group' => 'Data Ayah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir_ayah',
            'label' => 'Tanggal Lahir Ayah',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 21,
            'group' => 'Data Ayah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan_ayah',
            'label' => 'Pekerjaan Ayah',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 22,
            'group' => 'Data Ayah'
        ]);

        // Alamat Ayah
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'alamat_ayah',
            'label' => 'Alamat Lengkap Ayah',
            'tipe' => 'textarea',
            'is_required' => true,
            'urutan' => 23,
            'group' => 'Data Ayah'
        ]);

        // Data Orang Tua/Ibu
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_ibu',
            'label' => 'Nama Orang Tua/Ibu',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 24,
            'group' => 'Data Ibu'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir_ibu',
            'label' => 'Tempat Lahir Ibu',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 25,
            'group' => 'Data Ibu'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir_ibu',
            'label' => 'Tanggal Lahir Ibu',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 26,
            'group' => 'Data Ibu'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan_ibu',
            'label' => 'Pekerjaan Ibu',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 27,
            'group' => 'Data Ibu'
        ]);

        // Alamat Ibu
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'alamat_ibu',
            'label' => 'Alamat Lengkap Ibu',
            'tipe' => 'textarea',
            'is_required' => true,
            'urutan' => 28,
            'group' => 'Data Ibu'
        ]);

        // Tujuan SKCK
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tujuan_skck',
            'label' => 'Tujuan SKCK',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 29,
            'group' => 'Data Tujuan'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 30,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 31,
            'group' => 'Data Pengesahan'
        ]);
    }
}