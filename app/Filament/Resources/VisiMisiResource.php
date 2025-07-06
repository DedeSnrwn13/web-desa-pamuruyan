<?php

namespace App\Filament\Resources;

use App\Models\VisiMisi;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\VisiMisiResource\Pages;

class VisiMisiResource extends Resource
{
    protected static ?string $model = VisiMisi::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Visi & Misi';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Visi & Misi')
                    ->description('Informasi visi dan misi desa')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('periode')
                            ->label('Periode')
                            ->placeholder('Contoh: 2024-2029')
                            ->required()
                            ->maxLength(20)
                            ->unique(ignoreRecord: true)
                            ->helperText('Periode harus unik, tidak boleh sama dengan periode yang sudah ada.'),

                        Textarea::make('visi')
                            ->label('Visi')
                            ->placeholder('Masukkan visi desa')
                            ->required()
                            ->rows(3),

                        Repeater::make('misi')
                            ->label('Misi')
                            ->addActionLabel('Tambah Misi')
                            ->itemLabel(fn(array $state): ?string => $state['misi_item'] ?? null)
                            ->schema([
                                Textarea::make('misi_item')
                                    ->label('Misi')
                                    ->placeholder('Masukkan misi desa')
                                    ->required()
                                    ->rows(2),
                            ])
                            ->required()
                            ->minItems(1)
                            ->defaultItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->columns(1),

                        FileUpload::make('gambar')
                            ->label('Gambar Ilustrasi')
                            ->placeholder('Pilih gambar ilustrasi')
                            ->image()
                            ->imageEditor()
                            ->directory('visi-misi')
                            ->preserveFilenames()
                            ->uploadingMessage('Uploading gambar...')
                            ->maxSize(2048)
                            ->helperText('Format: JPG, PNG. Ukuran maksimal: 2MB'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),

                TextColumn::make('periode')
                    ->label('Periode')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('visi')
                    ->label('Visi')
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),

                TextColumn::make('misi')
                    ->label('Misi')
                    ->formatStateUsing(function ($state) {
                        // Jika null, return teks kosong
                        if (is_null($state)) {
                            return '';
                        }

                        // Jika string JSON, convert ke array
                        if (is_string($state)) {
                            $state = json_decode($state, true);
                        }

                        // Pastikan state adalah array
                        if (!is_array($state)) {
                            return '';
                        }

                        // Ambil semua misi_item dan gabungkan dengan nomor
                        return collect($state)->map(function ($item, $index) {
                            return ($index + 1) . '. ' . $item['misi_item'];
                        })->join('<br>');
                    })
                    ->html()
                    ->wrap()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        // Jika null, return null
                        if (is_null($state)) {
                            return null;
                        }

                        // Jika string JSON, convert ke array
                        if (is_string($state)) {
                            $state = json_decode($state, true);
                        }

                        // Pastikan state adalah array
                        if (!is_array($state)) {
                            return null;
                        }

                        // Format misi untuk tooltip
                        return collect($state)->map(function ($item, $index) {
                            return ($index + 1) . '. ' . $item['misi_item'];
                        })->join("\n");
                    }),

                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(url('images/visi-misi.svg')),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Diubah Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Visi & Misi')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data visi & misi ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Visi & Misi yang Dipilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data visi & misi yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus Semua')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisiMisis::route('/'),
            'create' => Pages\CreateVisiMisi::route('/create'),
            'edit' => Pages\EditVisiMisi::route('/{record}/edit'),
        ];
    }
}