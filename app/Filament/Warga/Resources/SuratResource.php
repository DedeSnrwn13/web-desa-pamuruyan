<?php

namespace App\Filament\Warga\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surat;
use Filament\Forms\Form;
use App\Enum\SuratStatus;
use App\Enum\JenisSuratEnum;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Warga\Resources\SuratResource\Pages;
use App\Models\JenisSurat;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;

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
                            ->default(fn() => Auth::id()),

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
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn($record) => $record?->status === SuratStatus::DISETUJUI->value),

                        DatePicker::make('tanggal_surat')
                            ->label('Tanggal Surat')
                            ->disabled()
                            ->dehydrated(false)
                            ->visible(fn($record) => $record?->status === SuratStatus::DISETUJUI->value),

                        TextInput::make('keterangan_admin')
                            ->label('Keterangan Admin')
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

                        $sections = [];
                        foreach ($formFields as $group => $groupFields) {
                            // Skip certain groups for specific surat types
                            if ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS_BANK->value) {
                                if (in_array($group, [
                                    'Data Alamat',
                                    'Data Surat',
                                    'Data Pengesahan',
                                ])) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS->value) {
                                if (in_array($group, [
                                    'Data Kepala Desa',
                                ])) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BEDA_NAMA->value) {
                                if (in_array($group, [
                                    'Data Surat',
                                    'Data Kepala Desa',
                                    'Data Pengesahan',
                                ])) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BELUM_KAWIN->value) {
                                if (in_array($group, [
                                    'Data Surat',
                                    'Data Kepala Desa',
                                    'Data Pengesahan',
                                ])) {
                                    continue;
                                }
                            } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_CATATAN_KEPOLISIAN->value) {
                                if (in_array($group, [
                                    'Data Surat',
                                    'Data Kepala Desa',
                                    'Data Pengesahan',
                                ])) {
                                    continue;
                                }
                            }

                            $fields = [];
                            foreach ($groupFields as $field) {
                                if ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS_BANK->value) {
                                    if (in_array($field->nama_field, [
                                        'nama_desa',
                                        'nomor_surat',
                                        'nama_camat',
                                        'nip_camat',
                                        'ttd_camat',
                                        'nama_kepala_desa',
                                        'ttd_kepala_desa',
                                    ])) {
                                        continue;
                                    }

                                    if (str_contains($group, 'Data Ahli Waris')) {
                                        $field->is_required = $group === 'Data Ahli Waris 1';
                                    }

                                    if ($group === 'Data Saksi') {
                                        $field->is_required = in_array($field->nama_field, ['nama_saksi_1', 'ttd_saksi_1']);
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_AHLI_WARIS->value) {
                                    if (in_array($field->nama_field, [
                                        'nama_kepala_desa',
                                    ])) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BEDA_NAMA->value) {
                                    if (in_array($field->nama_field, [
                                        'nomor_surat',
                                        'nama_kepala_desa',
                                        'tanggal_surat',
                                        'ttd_kepala_desa',
                                    ])) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_BELUM_KAWIN->value) {
                                    if (in_array($field->nama_field, [
                                        'nomor_surat',
                                        'nama_kepala_desa',
                                        'tanggal_surat',
                                        'ttd_kepala_desa',
                                        'ttd_pemohon',
                                    ])) {
                                        continue;
                                    }
                                } elseif ($jenisSurat->kode === JenisSuratEnum::KETERANGAN_CATATAN_KEPOLISIAN->value) {
                                    if (in_array($field->nama_field, [
                                        'nomor_surat',
                                        'nama_kepala_desa',
                                        'tanggal_surat',
                                        'ttd_kepala_desa',
                                        'ttd_pemohon',
                                    ])) {
                                        continue;
                                    }
                                }

                                $fields[] = match ($field->tipe) {
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
                                        ->required($field->is_required),
                                    'select' => Select::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Pilih {$field->label}")
                                        ->options(collect(explode(',', $field->opsi))->mapWithKeys(fn ($item) => [$item => $item]))
                                        ->required($field->is_required),
                                    'file' => FileUpload::make("form_fields.{$field->id}")
                                        ->label($field->label)
                                        ->placeholder("Unggah {$field->label}")
                                        ->required($field->is_required),
                                    default => null,
                                };
                            }

                            if (!empty($fields)) {
                                $sections[] = Section::make($group)
                                    ->schema($fields)
                                    ->columns(2);
                            }
                        }

                        return $sections;
                    })
                    ->visible(fn ($get) => (bool) $get('jenis_surat_id')),
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
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(
                fn(Builder $query) => $query
                    ->orderByRaw("FIELD(status, 'menunggu', 'disetujui', 'ditolak')")
                    ->orderBy('created_at', 'desc')
            )
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak'
                    ]),
                Tables\Filters\SelectFilter::make('jenis_surat')
                    ->relationship('jenisSurat', 'nama')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->status === 'menunggu'),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->url(fn(Surat $record) => $record->file_surat)
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
        return parent::getEloquentQuery()->where('warga_id', auth()->id());
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