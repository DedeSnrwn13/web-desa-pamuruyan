<?php

namespace App\Filament\Warga\Pages\Auth;

use App\Models\Rt;
use App\Models\Rw;
use App\Models\Kampung;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Auth\Register as BasePage;

class Register extends BasePage
{
    public ?array $data = [];

    public function getTitle(): string|Htmlable
    {
        return 'Registrasi Warga';
    }

    public function getHeading(): string|Htmlable
    {
        return 'Registrasi Warga';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Silakan daftar untuk mengakses layanan surat';
    }

    public function getLogo(): ?string
    {
        return asset('images/logo-kab-sukabumi.png');
    }

    public function getFooter(): string|Htmlable|null
    {
        return 'Desa Pamuruyan © ' . date('Y');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kampung_id')
                    ->label('Kampung')
                    ->placeholder('Pilih kampung')
                    ->options(Kampung::query()->pluck('nama', 'id'))
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('rw_id', null)),

                Select::make('rw_id')
                    ->label('RW')
                    ->placeholder('Pilih RW')
                    ->options(fn (Get $get): array => 
                        Rw::query()
                            ->where('kampung_id', $get('kampung_id'))
                            ->pluck('no_rw', 'id')
                            ->toArray()
                    )
                    ->required()
                    ->live()
                    ->visible(fn (Get $get): bool => filled($get('kampung_id')))
                    ->afterStateUpdated(fn (Set $set) => $set('rt_id', null)),

                Select::make('rt_id')
                    ->label('RT')
                    ->placeholder('Pilih RT')
                    ->options(fn (Get $get): array => 
                        Rt::query()
                            ->where('rw_id', $get('rw_id'))
                            ->pluck('no_rt', 'id')
                            ->toArray()
                    )
                    ->required()
                    ->visible(fn (Get $get): bool => filled($get('rw_id'))),

                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->placeholder('Masukkan nama lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->placeholder('Masukkan alamat email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique('wargas', 'email'),

                TextInput::make('password')
                    ->label('Kata Sandi')
                    ->placeholder('Masukkan kata sandi')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('password_confirmation')
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Konfirmasi Kata Sandi')
                    ->placeholder('Masukkan ulang kata sandi')
                    ->password()
                    ->required()
                    ->minLength(8),

                Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->placeholder('Pilih jenis kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan'
                    ])
                    ->required(),

                TextInput::make('no_telepon')
                    ->label('Nomor Telepon')
                    ->placeholder('Masukkan nomor telepon')
                    ->tel()
                    ->required()
                    ->maxLength(15),

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
                    ->label('Kewarganegaraan')
                    ->default('Indonesia'),
            ])
            ->columns(2);
    }

    protected function getRedirectUrl(): string
    {
        return '/warga';
    }
} 