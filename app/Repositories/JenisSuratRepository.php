<?php

namespace App\Repositories;

use App\Models\JenisSurat;

class JenisSuratRepository
{
    public function getLayananSurat($limit = 6)
    {
        return JenisSurat::take($limit)->get();
    }
}