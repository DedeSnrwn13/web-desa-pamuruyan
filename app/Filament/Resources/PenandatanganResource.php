<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenandatanganResource\Pages;
use App\Models\Penandatangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PenandatanganResource extends Resource
{
    protected static ?string $model = Penandatangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Penandatangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penandatangan')
                    ->schema([
                        Forms\Components\Select::make('surat_id')
                            ->relationship('surat', 'no_surat')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih surat'),

                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->placeholder('Masukkan nama penandatangan')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('jabatan')
                            ->required()
                            ->placeholder('Masukkan jabatan')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('ttd_path')
                            ->label('Tanda Tangan')
                            ->placeholder('Pilih tanda tangan')
                            ->required()
                            ->image()
                            ->directory('tanda-tangan')
                            ->preserveFilenames()
                            ->downloadable()
                            ->uploadingMessage('Mengupload tanda tangan...')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) date('Y-m-d-H-i-s') . '-' . str($file->getClientOriginalName())
                                    ->prepend('ttd-'),
                            )
                            ->columnSpanFull()
                            ->maxSize(2048)
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex(),

                Tables\Columns\TextColumn::make('surat.no_surat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('ttd_path')
                    ->label('Tanda Tangan'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn($record) => $record->surat->status !== 'menunggu'),
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
            'index' => Pages\ListPenandatangans::route('/'),
            'create' => Pages\CreatePenandatangan::route('/create'),
            'edit' => Pages\EditPenandatangan::route('/{record}/edit'),
        ];
    }
}