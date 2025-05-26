<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $fillable = ['periode', 'visi', 'misi', 'gambar'];

    protected $casts = [
        'misi' => 'array',
    ];

}