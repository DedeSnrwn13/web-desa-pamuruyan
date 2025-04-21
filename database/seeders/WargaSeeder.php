<?php

namespace Database\Seeders;

use App\Models\Rt;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rts = Rt::all();

        foreach ($rts as $rt) {
            for ($i = 1; $i <= 5; $i++) {
                Warga::create([
                    'rt_id' => $rt->id,
                    'nama' => "Warga {$rt->no_rt}-{$i}",
                    'email' => "warga{$rt->id}{$i}@example.com",
                    'password' => Hash::make('password123'),
                    'jenis_kelamin' => $i % 2 == 0 ? 'Laki-laki' : 'Perempuan',
                    'no_telepon' => "08123456" . str_pad($rt->id . $i, 4, '0', STR_PAD_LEFT),
                    'tempat_lahir' => 'Situbondo',
                    'tanggal_lahir' => '1990-01-01',
                    'pekerjaan' => 'Wiraswasta',
                    'agama' => 'Islam',
                    'status_perkawinan' => 'Kawin',
                    'kewarganegaraan' => 'Indonesia'
                ]);
            }
        }
    }
}