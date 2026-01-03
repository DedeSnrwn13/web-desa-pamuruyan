<?php

namespace App\Filament\Warga\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surat;
use Filament\Forms\Form;
use App\Enum\SuratStatus;
use App\Models\JenisSurat;
use Filament\Tables\Table;
use App\Enum\JenisSuratEnum;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Warga\Resources\SuratResource\Pages;
use Filament\Notifications\Notification;

class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Surat';

    protected static ?string $modelLabel = 'Surat';

    protected static ?string $pluralModelLabel = 'Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Surat')
                    ->description('Silakan isi informasi surat yang akan diajukan')
                    ->schema([
                        Hidden::make('warga_id')
                            ->default(fn() => Auth::guard('warga')->id()),

                        Select::make('jenis_surat_id')
                            ->relationship('jenisSurat', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih jenis surat')
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value && $record?->status !== null)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    return;
                                }

                                $jenisSurat = JenisSurat::find($state);
                                if (!$jenisSurat) {
                                    return;
                                }

                                $formFields = $jenisSurat->suratFormFields()
                                    ->orderBy('urutan')
                                    ->get()
                                    ->groupBy('group');

                                $fields = [];
                                foreach ($formFields as $group => $groupFields) {
                                    foreach ($groupFields as $field) {
                                        $fields[$field->id] = null;
                                    }
                                }

                                $set('form_fields', $fields);
                            }),

                        TextInput::make('keterangan_warga')
                            ->label('Keterangan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan keterangan/alasan pengajuan surat')
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value && $record?->status !== null),

                        TextInput::make('no_surat')
                            ->label('Nomor Surat')
                            ->placeholder('Masukkan nomor surat')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn($record) => $record?->status === SuratStatus::DISETUJUI->value),

                        DatePicker::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->placeholder('Pilih tanggal surat')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn($record) => $record?->status === SuratStatus::DISETUJUI->value),

                        TextInput::make('keterangan_admin')
                            ->label('Keterangan Admin')
                            ->placeholder('Masukkan keterangan admin')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn($record) => in_array($record?->status, [SuratStatus::DISETUJUI->value, SuratStatus::DITOLAK->value])),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->schema(function ($get) {
                        if (!$get('jenis_surat_id')) {
                            return [];
                        }

                        $jenisSurat = JenisSurat::find($get('jenis_surat_id'));
                        if (!$jenisSurat) {
                            return [];
                        }

                        $formFields = $jenisSurat->suratFormFields()
                            ->orderBy('urutan')
                            ->get()
                            ->groupBy('group');

                        // Find field IDs for tanggal_lahir_anak, tanggal_lahir_ayah, tanggal_lahir_ibu
                        $tanggalLahirAnakFieldId = $formFields->flatten()->firstWhere('nama_field', 'tanggal_lahir_anak')?->id;
                        $tanggalLahirFieldId = $formFields->flatten()->firstWhere('nama_field', 'tanggal_lahir')?->id;
                        if (!$tanggalLahirAnakFieldId) {
                            $tanggalLahirAnakFieldId = $tanggalLahirFieldId;
                        }
                        $tanggalLahirAyahFieldId = $formFields->flatten()->firstWhere('nama_field', 'tanggal_lahir_ayah')?->id;
                        $tanggalLahirIbuFieldId = $formFields->flatten()->firstWhere('nama_field', 'tanggal_lahir_ibu')?->id;

                        $sections = [];
                        foreach ($formFields as $group => $groupFields) {
                            // Skip certain groups for specific surat types
                            if ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS_BANK->value) {
                                if (
                                    in_array($group, [
                                        'Data Alamat',
                                        'Data Surat',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS->value) {
                                if (
                                    in_array($group, [
                                        'Data Kepala Desa',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BEDA_NAMA->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BELUM_KAWIN->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_CATATAN_KEPOLISIAN->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_DOMISILI->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_KEHILANGAN_AKTA_CERAI->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                        'Data KUA',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_KEMATIAN->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_TIDAK_MAMPU_BEASISWA->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    // Jika ada field ttd_pemohon, tetap tampilkan meskipun groupnya di-hide
                                    $hasRequiredField = false;
                                    foreach ($groupFields as $gField) {
                                        if ($gField->nama_field === 'ttd_pemohon') {
                                            $hasRequiredField = true;
                                            break;
                                        }
                                    }
                                    if (!$hasRequiredField) {
                                        continue;
                                    }
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_USAHA->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    // Jika ada field ttd_pemohon, tetap tampilkan meskipun groupnya di-hide
                                    $hasRequiredField = false;
                                    foreach ($groupFields as $gField) {
                                        if ($gField->nama_field === 'ttd_pemohon') {
                                            $hasRequiredField = true;
                                            break;
                                        }
                                    }
                                    if (!$hasRequiredField) {
                                        continue;
                                    }
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::PERNYATAAN_KEPEMILIKAN_TANAH->value) {
                                if (
                                    in_array($group, [
                                        'Data Surat',
                                        'Data Kepala Desa',
                                        'Data Pengesahan',
                                    ])
                                ) {
                                    // Jika ada field ttd_pemohon, tetap tampilkan meskipun groupnya di-hide
                                    $hasRequiredField = false;
                                    foreach ($groupFields as $gField) {
                                        if ($gField->nama_field === 'ttd_pemohon') {
                                            $hasRequiredField = true;
                                            break;
                                        }
                                    }
                                    if (!$hasRequiredField) {
                                        continue;
                                    }
                                }
                            }

                            $fields = [];
                            foreach ($groupFields as $field) {
                                // Skip certain fields based on surat type
                                if ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS_BANK->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nama_desa',
                                            'nomor_surat',
                                            'nama_camat',
                                            'nip_camat',
                                            'ttd_camat',
                                            'nama_kepala_desa',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }

                                    if (str_contains($group, 'Data Ahli Waris')) {
                                        $field->is_required = $group === 'Data Ahli Waris 1';
                                    }

                                    if ($group === 'Data Saksi') {
                                        $field->is_required = in_array($field->nama_field, ['nama_saksi_1', 'ttd_saksi_1']);
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nama_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BEDA_NAMA->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BELUM_KAWIN->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_CATATAN_KEPOLISIAN->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_DOMISILI->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'jabatan',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_KEHILANGAN_AKTA_CERAI->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'jabatan',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                            'nama_kepala_kua',
                                            'nip_kepala_kua',
                                            'ttd_kepala_kua',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_KEMATIAN->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_TIDAK_MAMPU_BEASISWA->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_USAHA->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::PERNYATAAN_KEPEMILIKAN_TANAH->value) {
                                    if (
                                        in_array($field->nama_field, [
                                            'nomor_surat',
                                            'nama_kepala_desa',
                                            'tanggal_surat',
                                            'ttd_kepala_desa',
                                        ])
                                    ) {
                                        continue;
                                    }
                                }

                                $component = match ($field->tipe) {
                                    'text' => TextInput::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Masukkan {$field->label}")
                                        ->required($field->is_required),
                                    'textarea' => Textarea::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Masukkan {$field->label}")
                                        ->required($field->is_required),
                                    'number' => TextInput::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Masukkan {$field->label}")
                                        ->numeric()
                                        ->required($field->is_required),
                                    'date' => DatePicker::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Pilih {$field->label}")
                                        ->format('Y-m-d')
                                        ->displayFormat('d/m/Y')
                                        ->required($field->is_required)
                                        ->live()
                                        ->disabled(function ($get) use ($field, $tanggalLahirAnakFieldId) {
                                                // Disable tanggal lahir ayah/ibu jika tanggal lahir anak belum diisi
                                                if (in_array($field->nama_field, ['tanggal_lahir_ayah', 'tanggal_lahir_ibu'])) {
                                                    if (!$tanggalLahirAnakFieldId) {
                                                        return false; // Field tidak ada, tidak perlu disable
                                                    }
                                                    $tanggalLahirAnak = $get("form_fields.{$tanggalLahirAnakFieldId}");
                                                    return empty($tanggalLahirAnak);
                                                }
                                                return false;
                                            }),
                                    'select' => Select::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Pilih {$field->label}")
                                        ->options(collect(explode(',', $field->opsi))->mapWithKeys(fn($item) => [$item => $item]))
                                        ->required($field->is_required),
                                    'file' => FileUpload::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Unggah {$field->label}")
                                        ->required($field->is_required)
                                        ->directory("lampiran-surat/temp")
                                        ->visibility('public')
                                        ->preserveFilenames()
                                        ->downloadable()
                                        ->previewable()
                                        ->acceptedFileTypes(['image/png', 'image/jpg', 'image/jpeg'])
                                        ->maxSize(2048),
                                    default => null,
                                };

                                // Apply validation rules based on field name
                                if ($component !== null) {
                                    // For tanggal_lahir_anak field, add afterStateUpdated to trigger update on ayah/ibu fields
                                    // Hanya jika field tanggal_lahir_anak ada dan field ayah/ibu juga ada
                                    if (
                                        $field->tipe === 'date' &&
                                        $tanggalLahirAnakFieldId &&
                                        ($field->nama_field === 'tanggal_lahir_anak' || $field->nama_field === 'tanggal_lahir') &&
                                        ($field->id == $tanggalLahirAnakFieldId) &&
                                        ($tanggalLahirAyahFieldId || $tanggalLahirIbuFieldId)
                                    ) {
                                        $component->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) use ($tanggalLahirAyahFieldId, $tanggalLahirIbuFieldId) {
                                            // Clear tanggal lahir ayah/ibu jika tanggal lahir anak berubah
                                            // Ini akan memicu re-evaluation dari maxDate pada field ayah/ibu
                                            if ($tanggalLahirAyahFieldId) {
                                                $currentAyah = $get("form_fields.{$tanggalLahirAyahFieldId}");
                                                if ($currentAyah && $state) {
                                                    try {
                                                        $tanggalAyah = Carbon::parse($currentAyah);
                                                        $tanggalAnak = Carbon::parse($state);
                                                        $minDate = $tanggalAnak->copy()->subYears(15);

                                                        // Jika tanggal ayah tidak valid, clear
                                                        if ($tanggalAyah->gt($minDate)) {
                                                            $set("form_fields.{$tanggalLahirAyahFieldId}", null);
                                                        }
                                                    } catch (\Exception $e) {
                                                        $set("form_fields.{$tanggalLahirAyahFieldId}", null);
                                                    }
                                                }
                                            }
                                            if ($tanggalLahirIbuFieldId) {
                                                $currentIbu = $get("form_fields.{$tanggalLahirIbuFieldId}");
                                                if ($currentIbu && $state) {
                                                    try {
                                                        $tanggalIbu = Carbon::parse($currentIbu);
                                                        $tanggalAnak = Carbon::parse($state);
                                                        $minDate = $tanggalAnak->copy()->subYears(15);

                                                        // Jika tanggal ibu tidak valid, clear
                                                        if ($tanggalIbu->gt($minDate)) {
                                                            $set("form_fields.{$tanggalLahirIbuFieldId}", null);
                                                        }
                                                    } catch (\Exception $e) {
                                                        $set("form_fields.{$tanggalLahirIbuFieldId}", null);
                                                    }
                                                }
                                            }
                                        });
                                    }

                                    // For date fields that depend on tanggal_lahir_anak, add dynamic maxDate
                                    // Hanya jika field tanggal_lahir_anak ada
                                    if (
                                        $field->tipe === 'date' &&
                                        in_array($field->nama_field, ['tanggal_lahir_ayah', 'tanggal_lahir_ibu']) &&
                                        $tanggalLahirAnakFieldId
                                    ) {
                                        // Set maxDate dinamis yang reactive terhadap perubahan tanggal_lahir_anak
                                        $component->maxDate(function ($get) use ($tanggalLahirAnakFieldId) {
                                            $tanggalLahirAnak = $get("form_fields.{$tanggalLahirAnakFieldId}");
                                            if ($tanggalLahirAnak) {
                                                try {
                                                    $tanggalAnak = Carbon::parse($tanggalLahirAnak);
                                                    // Return tanggal maksimal: tanggal anak - 15 tahun - 1 hari
                                                    return $tanggalAnak->copy()->subYears(15)->subDay();
                                                } catch (\Exception $e) {
                                                    return now()->subYears(32); // 17 + 15 = 32 tahun minimal
                                                }
                                            }
                                            // Jika tanggal lahir anak belum diisi, set default ke 32 tahun lalu
                                            return now()->subYears(32);
                                        })
                                            ->helperText('Harus minimal 15 tahun lebih dari tanggal lahir anak')
                                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) use ($tanggalLahirAnakFieldId, $field) {
                                            if ($state && $tanggalLahirAnakFieldId) {
                                                $tanggalLahirAnak = $get("form_fields.{$tanggalLahirAnakFieldId}");
                                                if ($tanggalLahirAnak) {
                                                    try {
                                                        $tanggalValue = Carbon::parse($state);
                                                        $tanggalAnak = Carbon::parse($tanggalLahirAnak);
                                                        $minDate = $tanggalAnak->copy()->subYears(15);

                                                        if ($tanggalValue->gt($minDate)) {
                                                            $set("form_fields.{$field->id}", null);
                                                            Notification::make()
                                                                ->danger()
                                                                ->title('Validasi Gagal')
                                                                ->body("Tanggal lahir " . ($field->nama_field === 'tanggal_lahir_ayah' ? 'ayah' : 'ibu') . " harus minimal 15 tahun lebih dari tanggal lahir anak")
                                                                ->send();
                                                        }
                                                    } catch (\Exception $e) {
                                                        // Ignore parsing errors
                                                    }
                                                }
                                            }
                                        });

                                        // Pastikan field ini reactive terhadap perubahan tanggal_lahir_anak
                                        // Key akan berubah ketika tanggal_lahir_anak berubah, memicu re-render
                                        $component->key(fn($get) => "tanggal_lahir_" . ($field->nama_field === 'tanggal_lahir_ayah' ? 'ayah' : 'ibu') . "_" . ($get("form_fields.{$tanggalLahirAnakFieldId}") ?? 'empty'));
                                    }

                                    $component = static::applyValidationRules(
                                        $component,
                                        $field->nama_field,
                                        $field->tipe,
                                        $field->is_required,
                                        $get
                                    );
                                    $fields[] = $component;
                                }
                            }

                            if (!empty($fields)) {
                                $sections[] = Section::make($group)
                                    ->schema($fields)
                                    ->columns(2);
                            }
                        }

                        return $sections;
                    })
                    ->visible(fn($get) => (bool) $get('jenis_surat_id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->placeholder('-'),

                TextColumn::make('tanggal_surat')
                    ->label('Tanggal Surat')
                    ->date()
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'ditinjau' => 'info',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => SuratStatus::from($state)->label())
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Diajukan pada')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('admin.name')
                    ->label('Ditinjau oleh')
                    ->placeholder('-'),
            ])
            ->defaultSort('created_at', 'asc')
            ->modifyQueryUsing(
                fn(Builder $query) => $query
                    ->orderByRaw("FIELD(status, 'ditinjau', 'menunggu', 'disetujui', 'ditolak')")
                    ->orderBy('created_at', 'asc')
            )
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(SuratStatus::class)
                    ->label('Status')
                    ->native(false)
                    ->searchable(),
                Tables\Filters\SelectFilter::make('jenis_surat')
                    ->relationship('jenisSurat', 'nama')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->status === SuratStatus::MENUNGGU->value),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->url(fn(Surat $record) => Storage::url($record->file_surat))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn(Surat $record) => $record->file_surat)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => false),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurats::route('/'),
            'create' => Pages\CreateSurat::route('/create'),
            'view' => Pages\ViewSurat::route('/{record}'),
            'edit' => Pages\EditSurat::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('warga_id', Auth::guard('warga')->id());
    }

    /**
     * Get validation rules based on field name
     */
    protected static function getValidationRules(string $namaField, string $tipe, bool $isRequired): array
    {
        $rules = [];

        // 1. Validasi Identitas (Angka Kependudukan)
        $identityFields16 = ['nik', 'no_ktp', 'nik_ayah', 'nik_ibu', 'nik_anak', 'nik_kk', 'nik_ktp', 'nik_almarhum'];
        $identityFields18 = ['nomor_sppt', 'nip_camat', 'nip_kepala_kua'];

        if (in_array($namaField, $identityFields16) || preg_match('/^nik_(ayah|ibu|anak|kk|ktp|almarhum)$/', $namaField)) {
            $rules[] = 'numeric';
            $rules[] = 'digits:16';
        } elseif (in_array($namaField, haystack: $identityFields18)) {
            $rules[] = 'numeric';
            $rules[] = 'digits:18';
        }

        // 2. Validasi Nama Orang
        $namaFields = [
            'nama',
            'nama_lengkap',
            'nama_ayah',
            'nama_ibu',
            'nama_anak',
            'nama_kk',
            'nama_ktp',
            'nama_almarhum',
            'nama_istri_almarhum',
            'nama_kepala_desa',
            'nama_camat',
            'nama_kepala_kua'
        ];

        // Check for numbered variants or exact matches
        if (
            preg_match('/^nama_(ahli_waris|saksi)_\d+$/', $namaField) ||
            in_array($namaField, $namaFields) ||
            (str_starts_with($namaField, 'nama_') && !in_array($namaField, ['nama_bank', 'nama_sekolah']))
        ) {
            $rules[] = 'string';
            $rules[] = 'min:3';
            $rules[] = 'max:150';
            $rules[] = 'regex:/^[a-zA-Z\s\.\']+$/';
        }

        // 3. Validasi Tanggal
        if ($tipe === 'date') {
            $rules[] = 'date';
            // Date-specific validations (before:today, before:-17 years) are handled in applyValidationRules
            // using DatePicker's maxDate() method for better UX
        }

        // 4. Validasi Wilayah & Angka Pendek (RT/RW/Umur)
        if (in_array($namaField, ['rt', 'rw', 'rt_almarhum', 'rw_almarhum', 'rt_kk', 'rw_kk', 'rt_ktp', 'rw_ktp'])) {
            $rules[] = 'numeric';
            $rules[] = 'max_digits:3';
        } elseif ($namaField === 'umur' || str_starts_with($namaField, 'umur_')) {
            $rules[] = 'integer';
            $rules[] = 'min:0';
            $rules[] = 'max:150';
        }

        // 5. Validasi Pilihan (Dropdown/Select) - handled by Filament Select component
        // No additional rules needed as Filament handles this

        // 6. Validasi Teks Bebas, Alamat & Deskripsi
        // Only apply if not already handled by other validations (identity, nama, etc.)
        if (empty($rules) && $tipe === 'text') {
            // Check if it's a known text field pattern (including variants with suffixes)
            $isTextField = preg_match('/^(alamat|tempat_lahir|dusun|desa|kecamatan|pekerjaan|kewarganegaraan|kebangsaan|jabatan|nama_sekolah|jurusan|nama_bank|jenis_usaha|register_desa|tempat_meninggal)(_|$)/', $namaField) ||
                in_array($namaField, [
                    'alamat',
                    'alamat_ayah',
                    'alamat_ibu',
                    'tempat_lahir',
                    'tempat_lahir_anak',
                    'tempat_lahir_kk',
                    'tempat_lahir_ktp',
                    'tempat_lahir_ayah',
                    'tempat_lahir_ibu',
                    'tempat_meninggal',
                    'dusun',
                    'dusun_almarhum',
                    'dusun_kk',
                    'dusun_ktp',
                    'desa',
                    'desa_almarhum',
                    'desa_kk',
                    'desa_ktp',
                    'kecamatan',
                    'kecamatan_almarhum',
                    'kecamatan_kk',
                    'kecamatan_ktp',
                    'pekerjaan',
                    'pekerjaan_ayah',
                    'pekerjaan_istri',
                    'pekerjaan_kk',
                    'kewarganegaraan',
                    'kewarganegaraan_kk',
                    'kewarganegaraan_ktp',
                    'kebangsaan',
                    'kebangsaan_kk',
                    'kebangsaan_ktp',
                    'jabatan',
                    'nama_sekolah',
                    'jurusan',
                    'nama_bank',
                    'jenis_usaha',
                    'register_desa'
                ]) ||
                preg_match('/^pekerjaan_ahli_waris_\d+$/', $namaField) ||
                preg_match('/^desa_ahli_waris_\d+$/', $namaField);

            if ($isTextField) {
                $rules[] = 'string';
                $rules[] = 'min:3';
            }
        }

        // Batas tanah boleh mengandung angka/meter
        if (in_array($namaField, ['batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat'])) {
            $rules[] = 'string';
            $rules[] = 'min:2';
        }

        // Textarea fields
        if ($tipe === 'textarea' || in_array($namaField, ['keperluan', 'tujuan_skck', 'tujuan_domisili', 'sebab_meninggal'])) {
            $rules[] = 'string';
            $rules[] = 'min:3';
        }

        // 7. Validasi Format Khusus (Regex)
        if ($namaField === 'nomor_surat') {
            $rules[] = 'string';
            $rules[] = 'regex:/^[\d\s\/\-]+$/';
        } elseif ($namaField === 'nomor_perkara') {
            $rules[] = 'string';
            $rules[] = 'regex:/^[\d\s\/\-\.]+$/';
        }

        // 8. Validasi Angka Nominal & Desimal
        if (in_array($namaField, ['penghasilan_perbulan', 'luas_tanah'])) {
            $rules[] = 'numeric';
            $rules[] = 'min:0';
        }

        // 9. Validasi File (Upload) - handled by Filament FileUpload component
        // Additional rules applied in component definition

        // Add required rule if needed
        if ($isRequired && !in_array('required', $rules)) {
            array_unshift($rules, 'required');
        }

        return $rules;
    }

    /**
     * Get validation messages based on field name
     */
    protected static function getValidationMessages(string $namaField, string $tipe): array
    {
        $messages = [];

        // 1. Validasi Identitas (Angka Kependudukan)
        $identityFields16 = ['nik', 'no_ktp', 'nik_ayah', 'nik_ibu', 'nik_anak', 'nik_kk', 'nik_ktp', 'nik_almarhum'];
        $identityFields18 = ['nomor_sppt', 'nip_camat', 'nip_kepala_kua'];

        if (in_array($namaField, $identityFields16) || preg_match('/^nik_(ayah|ibu|anak|kk|ktp|almarhum)$/', $namaField)) {
            $messages['digits'] = ':attribute harus :digits digit.';
            $messages['numeric'] = ':attribute harus berupa angka.';
        } elseif (in_array($namaField, $identityFields18)) {
            $messages['digits'] = ':attribute harus :digits digit.';
            $messages['numeric'] = ':attribute harus berupa angka.';
        }

        // 2. Validasi Nama Orang
        $namaFields = [
            'nama',
            'nama_lengkap',
            'nama_ayah',
            'nama_ibu',
            'nama_anak',
            'nama_kk',
            'nama_ktp',
            'nama_almarhum',
            'nama_istri_almarhum',
            'nama_kepala_desa',
            'nama_camat',
            'nama_kepala_kua'
        ];

        if (
            preg_match('/^nama_(ahli_waris|saksi)_\d+$/', $namaField) ||
            in_array($namaField, $namaFields) ||
            (str_starts_with($namaField, 'nama_') && !in_array($namaField, ['nama_bank', 'nama_sekolah']))
        ) {
            $messages['regex'] = ':attribute hanya boleh mengandung huruf, spasi, titik, dan petik satu.';
            $messages['min'] = ':attribute minimal :min karakter.';
            $messages['max'] = ':attribute maksimal :max karakter.';
        }

        // 3. Validasi Tanggal
        if ($tipe === 'date') {
            $messages['date'] = ':attribute harus berupa tanggal yang valid.';
            $messages['before'] = ':attribute harus tanggal sebelum :date.';
        }

        // 4. Validasi Wilayah & Angka Pendek (RT/RW/Umur)
        if (in_array($namaField, ['rt', 'rw', 'rt_almarhum', 'rw_almarhum', 'rt_kk', 'rw_kk', 'rt_ktp', 'rw_ktp'])) {
            $messages['numeric'] = ':attribute harus berupa angka.';
            $messages['max_digits'] = ':attribute maksimal :max digit.';
        } elseif ($namaField === 'umur' || str_starts_with($namaField, 'umur_')) {
            $messages['integer'] = ':attribute harus berupa bilangan bulat.';
            $messages['min'] = ':attribute minimal :min.';
            $messages['max'] = ':attribute maksimal :max.';
        }

        // 6. Validasi Teks Bebas, Alamat & Deskripsi
        if (empty($messages) && $tipe === 'text') {
            $messages['string'] = ':attribute harus berupa teks.';
            $messages['min'] = ':attribute minimal :min karakter.';
        }

        // Batas tanah
        if (in_array($namaField, ['batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat'])) {
            $messages['string'] = ':attribute harus berupa teks.';
            $messages['min'] = ':attribute minimal :min karakter.';
        }

        // Textarea fields
        if ($tipe === 'textarea' || in_array($namaField, ['keperluan', 'tujuan_skck', 'tujuan_domisili', 'sebab_meninggal'])) {
            $messages['string'] = ':attribute harus berupa teks.';
            $messages['min'] = ':attribute minimal :min karakter.';
        }

        // 7. Validasi Format Khusus (Regex)
        if ($namaField === 'nomor_surat') {
            $messages['regex'] = 'Format :attribute tidak valid.';
        } elseif ($namaField === 'nomor_perkara') {
            $messages['regex'] = 'Format :attribute tidak valid.';
        }

        // 8. Validasi Angka Nominal & Desimal
        if (in_array($namaField, ['penghasilan_perbulan', 'luas_tanah'])) {
            $messages['numeric'] = ':attribute harus berupa angka.';
            $messages['min'] = ':attribute minimal :min.';
        }

        // Required message
        $messages['required'] = ':attribute wajib diisi.';

        return $messages;
    }

    /**
     * Apply validation rules to a form component
     */
    protected static function applyValidationRules($component, string $namaField, string $tipe, bool $isRequired, $get = null)
    {
        $rules = static::getValidationRules($namaField, $tipe, $isRequired);

        if (!empty($rules)) {
            // For DatePicker, apply date-specific validations
            if ($tipe === 'date' && $component instanceof DatePicker) {
                // Skip untuk tanggal_lahir_ayah dan tanggal_lahir_ibu karena sudah di-handle dengan maxDate dinamis
                if (in_array($namaField, ['tanggal_lahir_ayah', 'tanggal_lahir_ibu'])) {
                    // MaxDate sudah di-set secara dinamis berdasarkan tanggal_lahir_anak
                    // Jangan override dengan maxDate statis
                }
                // Tanggal lahir harus di masa lalu
                elseif (str_contains($namaField, 'tanggal_lahir')) {
                    $component->maxDate(now()->subDay());

                    // Tanggal lahir untuk KTP harus 17 tahun ke atas
                    if (in_array($namaField, ['tanggal_lahir', 'tanggal_lahir_ktp'])) {
                        $component->maxDate(now()->subYears(17));
                    }
                }
                // Tanggal meninggal harus di masa lalu
                elseif ($namaField === 'tanggal_meninggal') {
                    $component->maxDate(now()->subDay());
                }
                // Tanggal kehilangan harus di masa lalu
                elseif ($namaField === 'tanggal_kehilangan') {
                    $component->maxDate(now()->subDay());
                }
                // Tanggal surat dan pernyataan bisa hari ini
                // No restriction needed
            }

            // Apply validation rules
            $component->rules($rules);

            // Apply validation messages dengan format yang benar
            $messages = static::getValidationMessages($namaField, $tipe);
            if (!empty($messages)) {
                // Format messages dengan mengganti :attribute dengan label field
                // Filament akan otomatis mengganti :digits, :min, :max, dll dengan nilai sebenarnya
                $component->validationMessages($messages);
            }
        }

        return $component;
    }

    public static function mutateFormDataBeforeFill(array $data): array
    {
        $record = static::getModel()::find($data['id']);
        if (!$record) {
            return $data;
        }

        // Get all form field values for this surat
        $formFieldValues = $record->suratFieldValues()
            ->with('suratFormField')
            ->get();

        // Map the values to the form_fields array
        $data['form_fields'] = $formFieldValues->mapWithKeys(function ($fieldValue) {
            return [$fieldValue->surat_form_field_id => $fieldValue->value];
        })->toArray();

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        Log::info('Form data before save:', $data);

        $formFields = $data['form_fields'] ?? [];
        unset($data['form_fields']);

        return $data;
    }

    public static function afterSave(Model $record, array $data): void
    {
        if (isset($data['form_fields'])) {
            Log::info('Saving form fields for surat #' . $record->id, [
                'form_fields' => $data['form_fields']
            ]);

            $record->saveFormFieldValues($data['form_fields']);
        }
    }
}
