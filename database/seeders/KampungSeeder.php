<?php

namespace Database\Seeders;

use App\Models\Kampung;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KampungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kampungs = [
            [
                'admin_id' => 1,
                'nama' => 'Paris'
            ],
            [
                'admin_id' => 1,
                'nama' => 'Anggayuda'
            ],
        ];

        foreach ($kampungs as $kampung) {
            Kampung::create($kampung);
        }
    }
}