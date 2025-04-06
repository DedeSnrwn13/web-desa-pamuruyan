<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Str;
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
            'nama' => 'Admin',
            'jabatan' => 'Admin',
            'email' => 'admin@desapamuruyan.com',
            'password' => bcrypt('password123'),
            'last_login' => now(),
            'remember_token' => Str::random(64),
        ]);
    }
}