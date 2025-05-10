<?php

namespace App\Repositories;

use App\Models\Berita;

class BeritaRepository
{
    public function getBeritaUtama($limit = 5)
    {
        return Berita::take($limit)
            ->inRandomOrder()
            ->get();
    }

    public function getBeritaTerbaru($limit = 3)
    {
        return Berita::where('status', 'PUBLISHED')
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }
}