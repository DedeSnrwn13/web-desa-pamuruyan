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
use Illuminate\Support\Facades\Storage;

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

            // Handle file uploads
            if ($field->tipe === 'file' && is_array($value)) {
                // For file uploads from Filament, the value will be an array with the first item being the path
                $filePath = reset($value); // Get first element regardless of key
                if ($filePath === null) {
                    continue;
                }

                // Move file to the correct directory
                $directory = "lampiran-surat/{$this->id}/{$field->nama_field}";

                // Check if the file exists in storage
                if (Storage::exists($filePath)) {
                    // Normalize filename: lowercase, replace spaces and symbols with dash
                    $originalName = basename($filePath);
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $filename = pathinfo($originalName, PATHINFO_FILENAME);

                    // Convert to lowercase and replace spaces/symbols with dash
                    $normalizedFilename = strtolower($filename);
                    $normalizedFilename = preg_replace('/[^a-z0-9]+/', '-', $normalizedFilename);
                    $normalizedFilename = trim($normalizedFilename, '-');

                    // Add extension back
                    $newFilename = $normalizedFilename . '.' . strtolower($extension);

                    // Move the file to new location with normalized name
                    $newPath = $directory . '/' . $newFilename;
                    Storage::move($filePath, $newPath);

                    // Create or update record in lampiran_surats table
                    $this->lampiranSurats()->updateOrCreate(
                        [
                            'surat_id' => $this->id,
                            'nama_file' => $field->nama_field,
                        ],
                        [
                            'path' => $newPath,
                            'nama_file' => $newFilename,
                        ]
                    );

                    // Update value to new path for saving in surat_field_values
                    $value = $newPath;
                }
            }

            // Determine which column to use based on field type
            $valueColumn = match ($field->tipe) {
                'text', 'textarea' => 'text_value',
                'number' => 'number_value',
                'date' => 'date_value',
                'select' => 'select_value',
                'file' => 'file_value',
                default => null
            };

            if ($valueColumn === null) {
                continue;
            }

            // For file type, store the full path
            if ($field->tipe === 'file') {
                $this->suratFieldValues()->updateOrCreate(
                    [
                        'surat_form_field_id' => $fieldId
                    ],
                    [
                        $valueColumn => $value
                    ]
                );
            } else {
                $this->suratFieldValues()->updateOrCreate(
                    [
                        'surat_form_field_id' => $fieldId
                    ],
                    [
                        $valueColumn => $value
                    ]
                );
            }
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