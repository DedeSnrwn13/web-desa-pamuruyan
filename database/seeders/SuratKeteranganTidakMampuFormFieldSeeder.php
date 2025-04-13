<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratKeteranganTidakMampuFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_TIDAK_MAMPU_BEASISWA->value)
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

        // Data Orang Tua
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_lengkap',
            'label' => 'Nama Lengkap',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Data Orang Tua'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik',
            'label' => 'NIK',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Data Orang Tua'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir',
            'label' => 'Tempat Lahir',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Data Orang Tua'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir',
            'label' => 'Tanggal Lahir',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Data Orang Tua'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin',
            'label' => 'Jenis Kelamin',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Data Orang Tua'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'status_perkawinan',
            'label' => 'Status Perkawinan',
            'tipe' => 'select',
            'opsi' => 'Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Data Orang Tua'
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

        // Data Ekonomi
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan',
            'label' => 'Pekerjaan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 14,
            'group' => 'Data Ekonomi'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'penghasilan_perbulan',
            'label' => 'Penghasilan Perbulan',
            'tipe' => 'number',
            'is_required' => true,
            'urutan' => 15,
            'group' => 'Data Ekonomi'
        ]);

        // Data Anak
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_anak',
            'label' => 'Nama Lengkap Anak',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 16,
            'group' => 'Data Anak'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik_anak',
            'label' => 'NIK Anak',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 17,
            'group' => 'Data Anak'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_lahir_anak',
            'label' => 'Tempat Lahir Anak',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 18,
            'group' => 'Data Anak'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_lahir_anak',
            'label' => 'Tanggal Lahir Anak',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 19,
            'group' => 'Data Anak'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin_anak',
            'label' => 'Jenis Kelamin Anak',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 20,
            'group' => 'Data Anak'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_sekolah',
            'label' => 'Nama Sekolah',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 21,
            'group' => 'Data Sekolah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jurusan',
            'label' => 'Jurusan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 22,
            'group' => 'Data Sekolah'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 23,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 24,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_pemohon',
            'label' => 'Tanda Tangan Pemohon',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => 25,
            'group' => 'Data Pengesahan'
        ]);
    }
}