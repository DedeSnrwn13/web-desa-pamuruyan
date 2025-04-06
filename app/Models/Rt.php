<?php

namespace App\Models;

use App\Models\Rw;
use App\Models\Admin;
use App\Models\Kampung;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rt extends Model
{
    protected $fillable = [
        'admin_id',
        'kampung_id',
        'rw_id',
        'no_rt'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function kampung(): BelongsTo
    {
        return $this->belongsTo(Kampung::class);
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }
}