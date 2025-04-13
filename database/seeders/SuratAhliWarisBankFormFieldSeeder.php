<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use App\Enum\JenisSuratEnum;
use App\Models\SuratFormField;
use Illuminate\Database\Seeder;

class SuratAhliWarisBankFormFieldSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSurat = JenisSurat::where('kode', JenisSuratEnum::KETERANGAN_AHLI_WARIS_BANK->value)
            ->first();

        // Data Bank
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_bank',
            'label' => 'Nama Bank',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 1,
            'group' => 'Data Bank',
        ]);

        // Data Almarhum
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_almarhum',
            'label' => 'Nama Almarhum',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 2,
            'group' => 'Data Almarhum'
        ]);

        // Data Alamat
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_desa',
            'label' => 'Nama Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 3,
            'group' => 'Data Alamat'
        ]);

        // Data Tanggal Meninggal
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_meninggal',
            'label' => 'Tanggal Meninggal',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => 4,
            'group' => 'Data Kematian'
        ]);

        // Data Istri
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_istri_almarhum',
            'label' => 'Nama Istri Almarhum',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 5,
            'group' => 'Data Istri'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'umur_istri',
            'label' => 'Umur Istri',
            'tipe' => 'number',
            'is_required' => true,
            'urutan' => 6,
            'group' => 'Data Istri'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'pekerjaan_istri',
            'label' => 'Pekerjaan Istri',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => 7,
            'group' => 'Data Istri'
        ]);

        // Data Anak (maksimal 10)
        $urutanAwal = 8; // Mulai dari 8 karena data sebelumnya sampai urutan 7
        for ($i = 1; $i <= 10; $i++) {
            $urutanBase = $urutanAwal + (($i - 1) * 4);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "nama_ahli_waris_$i",
                'label' => "Nama Ahli Waris $i",
                'tipe' => 'text',
                'is_required' => $i <= 3,
                'urutan' => $urutanBase,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "umur_ahli_waris_$i",
                'label' => "Umur Ahli Waris $i",
                'tipe' => 'number',
                'is_required' => $i <= 3,
                'urutan' => $urutanBase + 1,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "pekerjaan_ahli_waris_$i",
                'label' => "Pekerjaan Ahli Waris $i",
                'tipe' => 'text',
                'is_required' => $i <= 3,
                'urutan' => $urutanBase + 2,
                'group' => "Data Ahli Waris $i"
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "ttd_ahli_waris_$i",
                'label' => "Tanda Tangan Ahli Waris $i",
                'tipe' => 'file',
                'is_required' => $i <= 3,
                'urutan' => $urutanBase + 3,
                'group' => "Data Ahli Waris $i"
            ]);
        }

        // Hitung urutan awal untuk saksi
        $urutanAwalSaksi = $urutanAwal + (10 * 4); // 48

        // Data Saksi (maksimal 5)
        for ($i = 1; $i <= 5; $i++) {
            $urutanBase = $urutanAwalSaksi + (($i - 1) * 2);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "nama_saksi_$i",
                'label' => "Nama Saksi $i",
                'tipe' => 'text',
                'is_required' => $i <= 2,
                'urutan' => $urutanBase,
                'group' => 'Data Saksi'
            ]);

            SuratFormField::create([
                'jenis_surat_id' => $jenisSurat->id,
                'nama_field' => "ttd_saksi_$i",
                'label' => "Tanda Tangan Saksi $i",
                'tipe' => 'file',
                'is_required' => $i <= 2,
                'urutan' => $urutanBase + 1,
                'group' => 'Data Saksi'
            ]);
        }

        // Hitung urutan awal untuk data tambahan
        $urutanAwalTambahan = $urutanAwalSaksi + (5 * 2); // 58

        // Data Tambahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nomor_surat',
            'label' => 'Nomor Surat',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan,
            'group' => 'Data Surat'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'tanggal_surat',
            'label' => 'Tanggal Surat',
            'tipe' => 'date',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 1,
            'group' => 'Data Surat'
        ]);

        // Data Pengesahan
        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_camat',
            'label' => 'Nama Camat',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 2,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nip_camat',
            'label' => 'NIP Camat',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 3,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_camat',
            'label' => 'Tanda Tangan Camat',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 4,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'nama_kepala_desa',
            'label' => 'Nama Kepala Desa',
            'tipe' => 'text',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 5,
            'group' => 'Data Pengesahan'
        ]);

        SuratFormField::create([
            'jenis_surat_id' => $jenisSurat->id,
            'nama_field' => 'ttd_kepala_desa',
            'label' => 'Tanda Tangan Kepala Desa',
            'tipe' => 'file',
            'is_required' => true,
            'urutan' => $urutanAwalTambahan + 6,
            'group' => 'Data Pengesahan'
        ]);
    }
}