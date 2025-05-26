<?php

namespace App\Repositories;

use App\Models\VisiMisi;

class VisiMisiRepository
{
    public function getLatestVisiMisi()
    {
        return VisiMisi::latest()->first();
    }
}