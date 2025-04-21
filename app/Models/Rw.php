<?php

namespace App\Models;

use App\Models\Rt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rw extends Model
{
    protected $fillable = [
        'admin_id',
        'kampung_id',
        'no_rw'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function kampung(): BelongsTo
    {
        return $this->belongsTo(Kampung::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }
}