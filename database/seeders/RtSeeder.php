<?php

namespace Database\Seeders;

use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rws = Rw::all();

        foreach ($rws as $rw) {
            for ($i = 1; $i <= 10; $i++) {
                Rt::create([
                    'admin_id' => 1,
                    'kampung_id' => $rw->kampung_id,
                    'rw_id' => $rw->id,
                    'no_rt' => str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
            }
        }
    }
}