<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratAhliWarisFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_AHLI_WARIS->value)
            ->first();

        // Data Kepala Desa
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_kepala_desa',
            'label' => 'Nama Kepala Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 1,
            'group' => 'Data Kepala Desa'
        ]);

        // Data almarhum/almarhumah
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_almarhum',
            'label' => 'Nama Almarhum/Almarhumah',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 2,
            'group' => 'Data Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nik_almarhum',
            'label' => 'NIK',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Data Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'jenis_kelamin_almarhum',
            'label' => 'Jenis Kelamin',
            'tipe' => 'select',
            'opsi' => 'Laki-laki,Perempuan',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Data Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'dusun_almarhum',
            'label' => 'Dusun',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Alamat Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rt_almarhum',
            'label' => 'RT',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Alamat Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'rw_almarhum',
            'label' => 'RW',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Alamat Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'desa_almarhum',
            'label' => 'Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 8,
            'group' => 'Alamat Almarhum/Almarhumah'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'kecamatan_almarhum',
            'label' => 'Kecamatan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 9,
            'group' => 'Alamat Almarhum/Almarhumah'
        ]);

        // Data Kematian
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'hari_meninggal',
            'label' => 'Hari Meninggal',
            'tipe' => 'select',
            'opsi' => 'Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'is_required' => true,
            'urutan' => 10,
            'group' => 'Data Kematian'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_meninggal',
            'label' => 'Tanggal Meninggal',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 11,
            'group' => 'Data Kematian'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tempat_meninggal',
            'label' => 'Di',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 12,
            'group' => 'Data Kematian'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'sebab_meninggal',
            'label' => 'Disebabkan',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 13,
            'group' => 'Data Kematian'
        ]);

        // Data Ahli Waris
        for ($i = 1; $i <= 10; $i++) {
            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "nama_ahli_waris_$i",
                'label' => "Nama Ahli Waris $i",
                'tipe' => 'text',
                'is_required' => $i === 1,
                'urutan' => 13 + ($i * 5) - 4,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "hubungan_keluarga_$i",
                'label' => "Hubungan Keluarga $i",
                'tipe' => 'select',
                'opsi' => 'Istri/Suami,Anak',
                'is_required' => $i === 1,
                'urutan' => 13 + ($i * 5) - 3,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "tanggal_lahir_ahli_waris_$i",
                'label' => "Tanggal Lahir $i",
                'tipe' => 'date',
                'is_required' => $i === 1,
                'urutan' => 13 + ($i * 5) - 2,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "pekerjaan_ahli_waris_$i",
                'label' => "Pekerjaan $i",
                'tipe' => 'text',
                'is_required' => $i === 1,
                'urutan' => 13 + ($i * 5) - 1,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "desa_ahli_waris_$i",
                'label' => "Desa $i",
                'tipe' => 'text',
                'is_required' => $i === 1,
                'urutan' => 13 + ($i * 5),
                'group' => "Data Ahli Waris $i"
            ]);
        }
    }
}