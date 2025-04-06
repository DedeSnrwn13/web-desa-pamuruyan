<?php

namespace App\Models;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kampung extends Model
{
    protected $fillable = [
        'admin_id',
        'nama'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function rws(): HasMany
    {
        return $this->hasMany(Rw::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }
}