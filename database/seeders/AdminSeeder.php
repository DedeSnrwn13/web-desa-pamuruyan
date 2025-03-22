<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'nama_admin' => 'Admin',
            'email' => 'admin@desapamuruyan.com',
            'password' => bcrypt('password123'),
            'last_login' => now()
        ]);
    }
}