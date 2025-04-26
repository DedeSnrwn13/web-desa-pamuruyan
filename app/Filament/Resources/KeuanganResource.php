<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Keuangan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use App\Filament\Resources\KeuanganResource\Pages;

class KeuanganResource extends Resource
{
    protected static ?string $model = Keuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Manajemen Keuangan';

    protected static ?string $navigationLabel = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('admin_id')
                    ->default(fn() => Auth::guard('admin')->id()),

                Section::make('Informasi Transaksi')
                    ->schema([
                        TextInput::make('sumber_dana')
                            ->required()
                            ->maxLength(255)
                            ->label('Sumber Dana')
                            ->placeholder('Masukkan sumber dana'),
                        
                        TextInput::make('nominal')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Nominal')
                            ->placeholder('Masukkan nominal'),

                        Select::make('jenis_transaksi')
                            ->required()
                            ->options([
                                'Pemasukan' => 'Pemasukan',
                                'Pengeluaran' => 'Pengeluaran',
                            ])
                            ->label('Jenis Transaksi')
                            ->placeholder('Pilih jenis transaksi'),
                            
                        Textarea::make('keterangan')
                            ->required()
                            ->label('Keterangan')
                            ->placeholder('Masukkan keterangan'),

                        DateTimePicker::make('tanggal_transaksi')
                            ->required()
                            ->label('Tanggal Transaksi')
                            ->placeholder('Pilih tanggal transaksi'),

                        Select::make('status')
                            ->required()
                            ->options([
                                'Validasi' => 'Validasi',
                                'Belum Validasi' => 'Belum Validasi',
                            ])
                            ->default('Belum Validasi')
                            ->label('Status')
                            ->placeholder('Pilih status'),
                    ])->columns(2),

                Section::make('Informasi Anggaran')
                    ->schema([
                        TextInput::make('tahun_anggaran')
                            ->numeric()
                            ->label('Tahun Anggaran')
                            ->placeholder('Masukkan tahun anggaran'),

                        TextInput::make('nama_program')
                            ->maxLength(255)
                            ->label('Nama Program')
                            ->placeholder('Masukkan nama program'),

                        Select::make('kategori_anggaran')
                            ->options([
                                'Pendapatan' => 'Pendapatan',
                                'Belanja' => 'Belanja',
                                'Pembiayaan' => 'Pembiayaan',
                            ])
                            ->label('Kategori Anggaran')
                            ->placeholder('Pilih kategori anggaran'),

                        TextInput::make('sub_kategori')
                            ->maxLength(255)
                            ->label('Sub Kategori')
                            ->placeholder('Masukkan sub kategori'),
                    ])->columns(2),

                Section::make('Realisasi Anggaran')
                    ->schema([
                        TextInput::make('pagu_anggaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Pagu Anggaran')
                            ->placeholder('Masukkan pagu anggaran'),

                        TextInput::make('realisasi_anggaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Realisasi Anggaran')
                            ->placeholder('Masukkan realisasi anggaran'),

                        TextInput::make('persentase_realisasi')
                            ->numeric()
                            ->suffix('%')
                            ->label('Persentase Realisasi')
                            ->placeholder('Masukkan persentase realisasi'),

                        Select::make('status_realisasi')
                            ->options([
                                'Belum Realisasi' => 'Belum Realisasi',
                                'Sedang Berjalan' => 'Sedang Berjalan',
                                'Selesai' => 'Selesai',
                            ])
                            ->label('Status Realisasi')
                            ->placeholder('Pilih status realisasi'),
                    ])->columns(2),

                Section::make('Bukti Transaksi')
                    ->schema([
                        FileUpload::make('file_bukti')
                            ->directory('keuangan-bukti')
                            ->label('File Bukti')
                            ->placeholder('Pilih file bukti'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                TextColumn::make('sumber_dana')
                    ->searchable()
                    ->label('Sumber Dana'),

                TextColumn::make('nominal')
                    ->money('IDR')
                    ->sortable()
                    ->label('Nominal'),

                TextColumn::make('jenis_transaksi')
                    ->searchable()
                    ->label('Jenis Transaksi'),

                TextColumn::make('tanggal_transaksi')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Transaksi'),

                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Validasi' => 'success',
                        'Belum Validasi' => 'warning',
                    })
                    ->label('Status'),

                TextColumn::make('tahun_anggaran')
                    ->searchable()
                    ->label('Tahun Anggaran'),

                TextColumn::make('nama_program')
                    ->searchable()
                    ->label('Nama Program'),

                TextColumn::make('kategori_anggaran')
                    ->searchable()
                    ->label('Kategori Anggaran'),

                TextColumn::make('status_realisasi')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Belum Realisasi' => 'warning',
                        'Sedang Berjalan' => 'info',
                        'Selesai' => 'success',
                    })
                    ->label('Status Realisasi'),

                TextColumn::make('admin.name')
                    ->searchable()
                    ->label('Dibuat Oleh'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Diperbarui'),
            ])
            ->filters([
                SelectFilter::make('jenis_transaksi')
                    ->options([
                        'Pemasukan' => 'Pemasukan',
                        'Pengeluaran' => 'Pengeluaran',
                    ])
                    ->label('Jenis Transaksi'),

                SelectFilter::make('status')
                    ->options([
                        'Validasi' => 'Validasi',
                        'Belum Validasi' => 'Belum Validasi',
                    ])
                    ->label('Status'),

                SelectFilter::make('kategori_anggaran')
                    ->options([
                        'Pendapatan' => 'Pendapatan',
                        'Belanja' => 'Belanja',
                        'Pembiayaan' => 'Pembiayaan',
                    ])
                    ->label('Kategori Anggaran'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListKeuangans::route('/'),
            'create' => Pages\CreateKeuangan::route('/create'),
            'edit' => Pages\EditKeuangan::route('/{record}/edit'),
        ];
    }
} 