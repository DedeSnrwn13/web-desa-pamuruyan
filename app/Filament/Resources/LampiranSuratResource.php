<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LampiranSurat;
use Filament\Resources\Resource;
use App\Filament\Resources\LampiranSuratResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class LampiranSuratResource extends Resource
{
    protected static ?string $model = LampiranSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Lampiran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Lampiran')
                    ->schema([
                        Forms\Components\Select::make('surat_id')
                            ->relationship('surat', 'id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->getOptionLabelFromRecordUsing(fn($record) => 'ID Surat: ' . $record->id)
                            ->placeholder('Pilih surat'),

                        Forms\Components\TextInput::make('nama_file')
                            ->placeholder('Masukkan nama file')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('path')
                            ->label('File Lampiran')
                            ->placeholder('Pilih file lampiran')
                            ->required()
                            ->directory('lampiran-surat')
                            ->preserveFilenames()
                            ->downloadable()
                            ->previewable()
                            ->uploadingMessage('Uploading lampiran...')
                            ->directory('lampiran-surat')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) date('Y-m-d-H-i-s') . '-' . str($file->getClientOriginalName())
                                    ->prepend('lampiran-surat-'),
                            )
                            ->columnSpanFull()
                            ->maxSize(size: 5120),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: '#')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('surat.no_surat')
                    ->label('No Surat')
                    ->default('-'),

                Tables\Columns\TextColumn::make('nama_file')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn($record) => $record->surat->status !== 'menunggu'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLampiranSurats::route('/'),
            'view' => Pages\ViewLampiranSurat::route('/{record}'),
        ];
    }
}