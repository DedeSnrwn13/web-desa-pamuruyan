<?php

namespace Database\Seeders;

use App\Models\Surat;
use App\Models\Warga;
use App\Models\SuratFieldValue;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $wargas = Warga::take(2)->get();

        foreach ($wargas as $warga) {
            $surat = Surat::create([
                'admin_id' => 1,
                'warga_id' => $warga->id,
                'jenis_surat_id' => 1,
                'no_surat' => 'SKP/' . date('Y') . '/' . str_pad(rand(1, 100), 3, '0', STR_PAD_LEFT),
                'tanggal_surat' => now(),
                'status' => 'menunggu',
                'keterangan_warga' => 'Mengurus administrasi',
            ]);

            $fieldValues = [
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 1, // field nama
                    'value' => $warga->nama
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 2, // field tempat lahir
                    'value' => $warga->tempat_lahir
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 3, // field tanggal lahir
                    'value' => $warga->tanggal_lahir
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 4, // field jenis kelamin
                    'value' => $warga->jenis_kelamin
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 5, // field status perkawinan
                    'value' => $warga->status_perkawinan
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 6, // field no KTP
                    'value' => '3512' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT)
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 7, // field kewarganegaraan
                    'value' => $warga->kewarganegaraan
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 8, // field agama
                    'value' => $warga->agama
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 9, // field pekerjaan
                    'value' => $warga->pekerjaan
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 10, // field alamat
                    'value' => "RT {$warga->rt->no_rt} RW {$warga->rt->rw->no_rw} {$warga->rt->kampung->nama}"
                ],
                [
                    'surat_id' => $surat->id,
                    'surat_form_field_id' => 11, // field keperluan
                    'value' => 'Mengurus administrasi' . ' ' . ['KTP', 'KK', 'SKCK', 'Paspor'][rand(0, 3)]
                ],
            ];

            // Simpan semua field values
            foreach ($fieldValues as $fieldValue) {
                SuratFieldValue::create($fieldValue);
            }
        }
    }
}