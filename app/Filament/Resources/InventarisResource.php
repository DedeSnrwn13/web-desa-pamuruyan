<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use App\Models\Inventaris;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\InventarisResource\Pages\EditInventaris;
use App\Filament\Resources\InventarisResource\Pages\ListInventaris;
use App\Filament\Resources\InventarisResource\Pages\CreateInventaris;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Inventaris';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Barang')
                    ->schema([
                        TextInput::make('nama_barang')
                            ->placeholder('Masukkan nama barang')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('kode_barang')
                            ->placeholder('Masukkan kode barang')
                            ->required()
                            ->maxLength(50),

                        TextInput::make('jumlah')
                            ->placeholder('Masukkan jumlah barang')
                            ->required()
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('harga')
                            ->placeholder('Masukkan harga barang')
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),

                        Select::make('kondisi')
                            ->placeholder('Pilih kondisi barang')
                            ->options([
                                'baik' => 'Baik',
                                'rusak' => 'Rusak',
                                'hilang' => 'Hilang',
                                'dipinjam' => 'Dipinjam',
                                'dijual' => 'Dijual',
                            ])
                            ->live()
                            ->required(),

                        Select::make('status')
                            ->placeholder('Pilih status barang')
                            ->options([
                                'aktif' => 'Aktif',
                                'tidak aktif' => 'Tidak Aktif',
                                'diarsipkan' => 'Diarsipkan',
                                'dihapuskan' => 'Dihapuskan',
                            ])
                            ->default('aktif')
                            ->required(),
                    ])->columns(2),

                Section::make('Lokasi & Sumber')
                    ->schema([
                        TextInput::make('lokasi')
                            ->placeholder('Masukkan lokasi barang')
                            ->maxLength(255),

                        TextInput::make('sumber_dana')
                            ->placeholder('Masukkan sumber dana barang')
                            ->maxLength(255),

                        DatePicker::make('tanggal_pembelian')
                            ->placeholder('Pilih tanggal pembelian')
                            ->format('Y-m-d'),

                        DatePicker::make('tanggal_penjualan')
                            ->placeholder('Pilih tanggal penjualan')
                            ->format('Y-m-d')
                            ->visible(fn(Get $get) => $get('kondisi') === 'dijual'),
                    ])->columns(2),

                Section::make('Informasi Tambahan')
                    ->schema([
                        FileUpload::make('gambar')
                            ->placeholder('Pilih gambar barang')
                            ->image()
                            ->directory('inventaris')
                            ->visibility('public'),

                        Textarea::make('keterangan')
                            ->placeholder('Masukkan keterangan barang')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                ImageColumn::make('gambar')
                    ->square()
                    ->checkFileExistence(),

                TextColumn::make('kode_barang')
                    ->searchable(),

                TextColumn::make('nama_barang')
                    ->searchable(),

                TextColumn::make('jumlah')
                    ->sortable(),

                TextColumn::make('harga')
                    ->money('idr')
                    ->sortable(),

                TextColumn::make('lokasi')
                    ->searchable(),

                TextColumn::make('kondisi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'baik' => 'success',
                        'rusak' => 'danger',
                        'hilang' => 'gray',
                        'dipinjam' => 'warning',
                        'dijual' => 'info',
                        default => 'primary'
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'baik' => 'Baik',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                        'dipinjam' => 'Dipinjam',
                        'dijual' => 'Dijual',
                        default => $state
                    })
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'tidak aktif' => 'danger',
                        'diarsipkan' => 'warning',
                        'dihapuskan' => 'gray',
                        default => 'primary'
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'aktif' => 'Aktif',
                        'tidak aktif' => 'Tidak Aktif',
                        'diarsipkan' => 'Diarsipkan',
                        'dihapuskan' => 'Dihapuskan',
                        default => $state
                    })
                    ->sortable(),

                TextColumn::make('tanggal_pembelian')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kondisi')
                    ->options([
                        'baik' => 'Baik',
                        'rusak' => 'Rusak',
                        'hilang' => 'Hilang',
                        'dipinjam' => 'Dipinjam',
                        'dijual' => 'Dijual',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'diarsipkan' => 'Diarsipkan',
                        'dihapuskan' => 'Dihapuskan',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListInventaris::route('/'),
            'create' => CreateInventaris::route('/create'),
            'edit' => EditInventaris::route('/{record}/edit'),
        ];
    }
}