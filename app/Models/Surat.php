<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Warga;
use App\Models\JenisSurat;
use App\Models\LampiranSurat;
use App\Models\Penandatangan;
use App\Models\SuratFieldValue;
use App\Models\SuratFormField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Surat extends Model
{
    protected $fillable = [
        'admin_id',
        'warga_id',
        'jenis_surat_id',
        'status',
        'keterangan_warga',
        'keterangan_admin',
        'no_surat',
        'tanggal_surat',
        'file_surat'
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function suratFieldValues(): HasMany
    {
        return $this->hasMany(SuratFieldValue::class);
    }

    public function saveFormFieldValues(array $formFields): void
    {
        foreach ($formFields as $fieldId => $value) {
            if ($value === null) {
                continue;
            }

            $field = SuratFormField::find($fieldId);
            if (!$field) {
                continue;
            }

            $this->suratFieldValues()->updateOrCreate(
                ['surat_form_field_id' => $fieldId],
                ['value' => $value]
            );
        }
    }

    public function lampiranSurats(): HasMany
    {
        return $this->hasMany(LampiranSurat::class);
    }

    public function penandatangans(): HasMany
    {
        return $this->hasMany(Penandatangan::class);
    }
}