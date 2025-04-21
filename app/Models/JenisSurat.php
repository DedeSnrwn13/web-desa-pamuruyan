<?php

namespace App\Models;

use App\Models\Surat;
use App\Models\SuratFormField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisSurat extends Model
{
    protected $fillable = [
        'admin_id',
        'nama',
        'kode'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    public function suratFormFields(): HasMany
    {
        return $this->hasMany(SuratFormField::class);
    }
}