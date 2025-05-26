<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kepengurusan extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'pendidikan',
        'no_sk',
        'tanggal_sk',
        'masa_jabatan_mulai',
        'masa_jabatan_selesai',
        'status_aktif',
        'foto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_sk' => 'date',
        'masa_jabatan_mulai' => 'date',
        'masa_jabatan_selesai' => 'date',
        'status_aktif' => 'boolean',
    ];
}