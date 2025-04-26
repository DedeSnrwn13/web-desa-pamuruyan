<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Jadwal;
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
use App\Filament\Resources\JadwalResource\Pages;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Manajemen Kegiatan';

    protected static ?string $navigationLabel = 'Jadwal Kegiatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('admin_id')
                    ->default(fn() => Auth::guard('admin')->id()),

                Section::make('Informasi Kegiatan')
                    ->schema([
                        TextInput::make('nama_kegiatan')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kegiatan')
                            ->placeholder('Masukkan Nama Kegiatan'),
                        
                        DateTimePicker::make('waktu')
                            ->required()
                            ->label('Waktu Mulai')
                            ->placeholder('Masukkan Waktu Mulai'),
                            
                        DateTimePicker::make('waktu_selesai')
                            ->label('Waktu Selesai')
                            ->placeholder('Masukkan Waktu Selesai'),
                            
                        TextInput::make('lokasi')
                            ->required()
                            ->maxLength(255)
                            ->label('Lokasi')
                            ->placeholder('Masukkan Lokasi'),
                            
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan Deskripsi'),
                            
                        Select::make('status_kegiatan')
                            ->required()
                            ->options([
                                'Belum Dimulai' => 'Belum Dimulai',
                                'Berjalan' => 'Berjalan',
                                'Selesai' => 'Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('Belum Dimulai')
                            ->label('Status Kegiatan')
                            ->placeholder('Pilih Status Kegiatan'),
                    ])->columns(2),

                Section::make('Informasi Tambahan')
                    ->schema([
                        TextInput::make('penanggung_jawab')
                            ->maxLength(255)
                            ->label('Penanggung Jawab')
                            ->placeholder('Masukkan Penanggung Jawab'),
                            
                        TextInput::make('jumlah_peserta')
                            ->numeric()
                            ->label('Jumlah Peserta')
                            ->placeholder('Masukkan Jumlah Peserta'),
                            
                        TextInput::make('anggaran')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Anggaran')
                            ->placeholder('Masukkan Anggaran'),
                            
                        Textarea::make('keterangan_tambahan')
                            ->label('Keterangan Tambahan')
                            ->placeholder('Masukkan Keterangan Tambahan'),
                    ])->columns(2),

                Section::make('Dokumentasi')
                    ->schema([
                        FileUpload::make('foto_kegiatan')
                            ->directory('jadwal-foto')
                            ->label('Foto Kegiatan')
                            ->placeholder('Pilih Foto Kegiatan'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),
                    
                TextColumn::make('nama_kegiatan')
                    ->searchable()
                    ->label('Nama Kegiatan'),
                    
                TextColumn::make('waktu')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Mulai'),
                    
                TextColumn::make('waktu_selesai')
                    ->dateTime()
                    ->sortable()
                    ->label('Waktu Selesai'),
                    
                TextColumn::make('lokasi')
                    ->searchable()
                    ->label('Lokasi'),
                    
                TextColumn::make('status_kegiatan')
                    ->searchable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Belum Dimulai' => 'gray',
                        'Berjalan' => 'info',
                        'Selesai' => 'success',
                        'Dibatalkan' => 'danger',
                    })
                    ->label('Status'),
                    
                TextColumn::make('penanggung_jawab')
                    ->searchable()
                    ->label('Penanggung Jawab'),
                    
                TextColumn::make('jumlah_peserta')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah Peserta'),
                    
                TextColumn::make('anggaran')
                    ->money('IDR')
                    ->sortable()
                    ->label('Anggaran'),

                TextColumn::make('admin.name')
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
                SelectFilter::make('status_kegiatan')
                    ->options([
                        'Belum Dimulai' => 'Belum Dimulai',
                        'Berjalan' => 'Berjalan',
                        'Selesai' => 'Selesai',
                        'Dibatalkan' => 'Dibatalkan',
                    ])
                    ->label('Status Kegiatan'),
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
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }
} 