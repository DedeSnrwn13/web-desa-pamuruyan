<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\RtSeeder;
use Database\Seeders\RwSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\SuratSeeder;
use Database\Seeders\WargaSeeder;
use Database\Seeders\KampungSeeder;
use Database\Seeders\JenisSuratSeeder;
use Database\Seeders\KategoriBeritaSeeder;
use Database\Seeders\SuratFormFieldSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KampungSeeder::class,
            RwSeeder::class,
            RtSeeder::class,
            WargaSeeder::class,
            JenisSuratSeeder::class,
            SuratFormFieldSeeder::class,
            KategoriBeritaSeeder::class,
            SuratSeeder::class,
        ]);
    }
}