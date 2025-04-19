<?php

namespace App\Models;

use App\Models\Surat;
use App\Models\SuratFormField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SuratFieldValue extends Model
{
    protected $fillable = [
        'surat_id',
        'surat_form_field_id',
        'text_value',
        'number_value',
        'date_value',
        'select_value'
    ];

    protected $casts = [
        'date_value' => 'date',
        'number_value' => 'decimal:2'
    ];

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class);
    }

    public function suratFormField(): BelongsTo
    {
        return $this->belongsTo(SuratFormField::class);
    }


    protected function value(): Attribute
    {
        return Attribute::make(
            get: function () {
                return match ($this->suratFormField->tipe) {
                    'text', 'textarea' => $this->text_value,
                    'number' => $this->number_value,
                    'date' => $this->date_value,
                    'select' => $this->select_value,
                    default => null
                };
            },
            set: function ($value) {
                $tipe = $this->suratFormField->tipe;

                return match ($tipe) {
                    'text', 'textarea' => ['text_value' => $value],
                    'number' => ['number_value' => $value],
                    'date' => ['date_value' => $value],
                    'select' => ['select_value' => $value],
                    default => []
                };
            }
        );
    }
}