<?php

namespace App\Filament\Resources;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\Surat;
use App\Models\Warga;
use App\Models\Kampung;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\WargaResource\Pages;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Hash;

class WargaResource extends Resource
{
    protected static ?string $model = Warga::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?string $navigationLabel = 'Data Warga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Wilayah')
                    ->description('Pilih lokasi tempat tinggal warga')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Select::make('kampung_id')
                            ->label('Kampung')
                            ->placeholder('Pilih kampung')
                            ->options(function () {
                                return Kampung::query()->pluck('nama', 'id');
                            })
                            ->required()
                            ->live()
                            ->searchable(false)
                            ->preload()
                            ->afterStateHydrated(function (Set $set, ?Warga $record) {
                                if ($record) {
                                    $kampungId = $record?->rt?->rw?->kampung_id;
                                    $set('kampung_id', $kampungId);
                                    $set('rw_id', $record?->rt?->rw_id);
                                    $set('rt_id', $record->rt_id);
                                }
                            })
                            ->afterStateUpdated(function (Set $set, $state) {
                                // Reset RW dan RT jika Kampung berubah
                                $set('rw_id', null);
                                $set('rt_id', null);
                            }),

                        Select::make('rw_id')
                            ->label('RW')
                            ->placeholder('Pilih RW')
                            ->options(function (Get $get): array {
                                if (!$get('kampung_id')) {
                                    return [];
                                }
                                return Rw::query()
                                    ->where('kampung_id', $get('kampung_id'))
                                    ->pluck('no_rw', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->live()
                            ->afterStateHydrated(function (Set $set, ?Warga $record) {
                                if ($record) {
                                    $set('rw_id', $record?->rt?->rw_id);
                                }
                            })
                            ->afterStateUpdated(function (Set $set, $state) {
                                // Reset RT jika RW berubah
                                $set('rt_id', null);
                            })
                            ->visible(fn(Get $get, ?Warga $record): bool => filled($get('kampung_id')) || filled($record?->rt?->rw_id)),

                        Select::make('rt_id')
                            ->label('RT')
                            ->placeholder('Pilih RT')
                            ->options(function (Get $get): array {
                                if (!$get('rw_id')) {
                                    return [];
                                }
                                return Rt::query()
                                    ->where('rw_id', $get('rw_id'))
                                    ->pluck('no_rt', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->afterStateHydrated(function (Set $set, ?Warga $record) {
                                if ($record) {
                                    $set('rt_id', $record->rt_id);
                                }
                            })
                            ->visible(fn(Get $get, ?Warga $record): bool => filled($get('rw_id')) || filled($record?->rt_id)),
                    ])
                    ->columns(3),

                Section::make('Data Pribadi')
                    ->description('Informasi data diri warga')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap')
                            ->required()
                            ->maxLength(255),

                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->placeholder('Pilih jenis kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan'
                            ])
                            ->required(),

                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->placeholder('Masukkan tempat lahir')
                            ->required()
                            ->maxLength(100),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->placeholder('Pilih tanggal lahir')
                            ->required()
                            ->maxDate(now()),

                        TextInput::make('pekerjaan')
                            ->label('Pekerjaan')
                            ->placeholder('Masukkan pekerjaan')
                            ->required()
                            ->maxLength(255),

                        Select::make('agama')
                            ->label('Agama')
                            ->placeholder('Pilih agama')
                            ->options([
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Konghucu' => 'Konghucu'
                            ])
                            ->required(),

                        Select::make('status_perkawinan')
                            ->label('Status Perkawinan')
                            ->placeholder('Pilih status perkawinan')
                            ->options([
                                'Belum Kawin' => 'Belum Kawin',
                                'Kawin' => 'Kawin',
                                'Cerai Hidup' => 'Cerai Hidup',
                                'Cerai Mati' => 'Cerai Mati'
                            ])
                            ->required(),

                        Hidden::make('kewarganegaraan')
                            ->default('Indonesia')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Informasi Kontak')
                    ->description('Informasi kontak yang dapat dihubungi')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->schema([
                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon')
                            ->placeholder('Masukkan nomor telepon')
                            ->tel()
                            ->required()
                            ->maxLength(15),

                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->placeholder('Masukkan alamat email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ])
                    ->columns(2),

                Section::make('Akun')
                    ->description('Pengaturan kata sandi akun')
                    ->icon('heroicon-o-key')
                    ->schema([
                        TextInput::make('password')
                            ->label('Kata Sandi')
                            ->placeholder(fn(?Warga $record) => $record ? 'Biarkan kosong jika tidak ingin mengubah kata sandi' : 'Masukkan kata sandi')
                            ->password()
                            ->required(fn(?Warga $record) => !$record)
                            ->minLength(8)
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (blank($state)) {
                                    $set('password_confirmation', null);
                                }
                            }),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Kata Sandi')
                            ->placeholder(fn(?Warga $record) => $record ? 'Biarkan kosong jika tidak ingin mengubah kata sandi' : 'Masukkan ulang kata sandi')
                            ->password()
                            ->required(fn(Get $get) => filled($get('password')))
                            ->minLength(8)
                            ->same('password')
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('no_telepon')
                    ->searchable(),

                TextColumn::make('jenis_kelamin')
                    ->searchable(),

                TextColumn::make('pekerjaan')
                    ->searchable(),

                TextColumn::make('agama')
                    ->searchable(),

                TextColumn::make('rt.no_rt')
                    ->label('RT')
                    ->default(fn($record) => $record?->rt?->no_rt ?? '-')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rt.rw.no_rw')
                    ->label('RW')
                    ->default(fn($record) => $record?->rt?->rw?->no_rw ?? '-')
                    ->searchable(),

                TextColumn::make('rt.rw.kampung.nama')
                    ->label('Kampung')
                    ->default(fn($record) => $record?->rt?->rw?->kampung?->nama ?? '-')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Register pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                Action::make('delete')
                    ->label('Hapus')
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Data Warga')
                    ->modalSubheading('Apakah Anda yakin ingin menghapus data warga ini? Seluruh data terkait juga akan dihapus.')
                    ->action(function ($record) {
                        try {
                            Surat::where('warga_id', $record->id)->delete();
                            $record->delete();
                            Notification::make()
                                ->title('Data Warga Berhasil Dihapus')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal Menghapus Data')
                                ->danger()
                                ->body('Terjadi kesalahan saat menghapus data warga.')
                                ->send();
                        }
                    })
                    ->color('danger'),
            ])
            ->defaultSort('nama');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWargas::route('/'),
            'edit' => Pages\EditWarga::route('/{record}/edit'),
        ];
    }
}