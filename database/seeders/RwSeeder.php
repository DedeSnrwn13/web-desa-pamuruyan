<?php

namespace Database\Seeders;

use App\Models\Rw;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RwSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($kampung_id = 1; $kampung_id <= 2; $kampung_id++) {
            for ($i = 1; $i <= 5; $i++) {
                Rw::create([
                    'admin_id' => 1,
                    'kampung_id' => $kampung_id,
                    'no_rw' => str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
            }
        }
    }
}