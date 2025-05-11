<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganKehilanganAktaCeraiFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_KEHILANGAN_AKTA_CERAI->value)
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
            'label' => 'Nama Lengkap',
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
            'nama_field' => 'umur',
            'label' => 'Umur',
            'tipe' => 'number',
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
            'nama_field' => 'pendidikan',
            'label' => 'Pendidikan',
            'tipe' => 'select',
            'opsi' => 'Tidak Sekolah,SD,SMP,SMA,D1,D2,D3,S1,S2,S3',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Data Pemohon'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_pemohon',
            'label' => 'Tanda Tangan Pemohon',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Data Pemohon'
        ]);

        // Alamat
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'alamat',
            'label' => 'Alamat',
            'tipe' => 'textarea',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Alamat'
        ]);

        // Data Kehilangan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_kehilangan',
            'label' => 'Tanggal Kehilangan',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Data Kehilangan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nomor_perkara',
            'label' => 'Nomor Perkara',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Data Kehilangan'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_kepala_kua',
            'label' => 'Nama Kepala KUA',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Data KUA'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nip_kepala_kua',
            'label' => 'NIP Kepala KUA',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Data KUA'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_kua',
            'label' => 'Tanda Tangan Kepala KUA',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 20,
            'group' => 'Data KUA'
        ]);
    }
}