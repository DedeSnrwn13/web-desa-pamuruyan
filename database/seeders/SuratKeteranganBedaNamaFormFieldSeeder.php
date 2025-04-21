<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganBedaNamaFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_BEDA_NAMA->value)
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

        // Data KK (Identitas di KK)
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_kk',
            'label' => 'Nama Lengkap (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik_kk',
            'label' => 'NIK (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir_kk',
            'label' => 'Tempat Lahir (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir_kk',
            'label' => 'Tanggal Lahir (KK)',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kebangsaan_kk',
            'label' => 'Kebangsaan (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'agama_kk',
            'label' => 'Agama (KK)',
            'tipe' => 'select',
            'opsi' => 'Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin_kk',
            'label' => 'Jenis Kelamin (KK)',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 9,
            'group' => 'Identitas KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan_kk',
            'label' => 'Pekerjaan (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Identitas KK'
        ]);

        // Alamat KK
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun_kk',
            'label' => 'Dusun (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Alamat KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt_kk',
            'label' => 'RT (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Alamat KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw_kk',
            'label' => 'RW (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Alamat KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa_kk',
            'label' => 'Desa (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Alamat KK'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan_kk',
            'label' => 'Kecamatan (KK)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Alamat KK'
        ]);

        // Data KTP (Identitas di KTP)
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_ktp',
            'label' => 'Nama Lengkap (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik_ktp',
            'label' => 'NIK (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir_ktp',
            'label' => 'Tempat Lahir (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir_ktp',
            'label' => 'Tanggal Lahir (KTP)',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kebangsaan_ktp',
            'label' => 'Kebangsaan (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 20,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'agama_ktp',
            'label' => 'Agama (KTP)',
            'tipe' => 'select',
            'opsi' => 'Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'is_required' => true,
            'urutan' => 21,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin_ktp',
            'label' => 'Jenis Kelamin (KTP)',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 22,
            'group' => 'Identitas KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan_ktp',
            'label' => 'Pekerjaan (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 23,
            'group' => 'Identitas KTP'
        ]);

        // Alamat KTP
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun_ktp',
            'label' => 'Dusun (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 24,
            'group' => 'Alamat KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt_ktp',
            'label' => 'RT (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 25,
            'group' => 'Alamat KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw_ktp',
            'label' => 'RW (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 26,
            'group' => 'Alamat KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa_ktp',
            'label' => 'Desa (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 27,
            'group' => 'Alamat KTP'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan_ktp',
            'label' => 'Kecamatan (KTP)',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 28,
            'group' => 'Alamat KTP'
        ]);

        // Data Keterangan Tambahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'data_yang_benar',
            'label' => 'Data Yang Benar',
            'tipe' => 'select',
            'opsi' => 'Data KK,Data KTP',
            'is_required' => true,
            'urutan' => 29,
            'group' => 'Data Keterangan'
        ]);

        // Data Pengesahan (urutan digeser)
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