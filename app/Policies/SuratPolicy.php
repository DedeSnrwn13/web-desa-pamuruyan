<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Surat;

class SuratPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function review(Admin $admin, Surat $surat): bool
    {
        return $surat->status === 'menunggu';
    }
}