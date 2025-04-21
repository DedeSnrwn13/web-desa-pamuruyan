<?php

namespace App\Models;

use App\Models\JenisSurat;
use App\Models\SuratFieldValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratFormField extends Model
{
    protected $fillable = [
        'jenis_surat_id',
        'nama_field',
        'label',
        'tipe',
        'opsi',
        'is_required',
        'urutan',
        'group'
    ];

    protected $casts = [
        'opsi' => 'array',
        'is_required' => 'boolean'
    ];

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function suratFieldValues(): HasMany
    {
        return $this->hasMany(SuratFieldValue::class);
    }
}