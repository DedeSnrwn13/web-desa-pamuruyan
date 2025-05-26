<?php

namespace App\Filament\Resources;

use App\Models\Kepengurusan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use App\Enum\KepengurusanEnum;
use App\Filament\Resources\KepengurusanResource\Pages;

class KepengurusanResource extends Resource
{
    protected static ?string $model = Kepengurusan::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Kepengurusan';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pribadi')
                    ->description('Informasi dasar pengurus desa')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->placeholder('Masukkan nama lengkap')
                            ->required()
                            ->maxLength(255),

                        Select::make('jabatan')
                            ->label('Jabatan')
                            ->placeholder('Pilih jabatan')
                            ->options(KepengurusanEnum::getOptions())
                            ->required()
                            ->helperText(function (Select $component) {
                                $value = $component->getState();
                                if ($value) {
                                    $enum = KepengurusanEnum::from($value);
                                    return $enum->getDescription($enum);
                                }
                                return null;
                            }),

                        Select::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->placeholder('Pilih jenis kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->placeholder('Pilih tanggal lahir')
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d')
                            ->maxDate(now()),

                        TextInput::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat lengkap')
                            ->maxLength(255),

                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon')
                            ->placeholder('Masukkan nomor telepon')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('pendidikan')
                            ->label('Pendidikan Terakhir')
                            ->placeholder('Masukkan pendidikan terakhir')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Informasi Jabatan')
                    ->description('Detail SK dan masa jabatan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('no_sk')
                            ->label('Nomor SK')
                            ->placeholder('Masukkan nomor SK')
                            ->maxLength(255),

                        DatePicker::make('tanggal_sk')
                            ->label('Tanggal SK')
                            ->placeholder('Pilih tanggal SK')
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),

                        DatePicker::make('masa_jabatan_mulai')
                            ->label('Masa Jabatan Mulai')
                            ->placeholder('Pilih tanggal mulai jabatan')
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),

                        DatePicker::make('masa_jabatan_selesai')
                            ->label('Masa Jabatan Selesai')
                            ->placeholder('Pilih tanggal selesai jabatan')
                            ->displayFormat('d/m/Y')
                            ->format('Y-m-d'),

                        Toggle::make('status_aktif')
                            ->label('Status Aktif')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make('Foto')
                    ->description('Unggah foto pengurus')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        FileUpload::make('foto')
                            ->label('Foto')
                            ->image()
                            ->imageEditor()
                            ->directory('pengurus')
                            ->preserveFilenames()
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

                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('masa_jabatan_mulai')
                    ->label('Mulai Jabatan')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('masa_jabatan_selesai')
                    ->label('Selesai Jabatan')
                    ->date('d/m/Y')
                    ->sortable(),

                ToggleColumn::make('status_aktif')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->disabled(),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Pengurus')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data pengurus ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Pengurus yang Dipilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data pengurus yang dipilih?')
                        ->modalSubmitActionLabel('Ya, Hapus Semua')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKepengurusans::route('/'),
            'create' => Pages\CreateKepengurusan::route('/create'),
            'edit' => Pages\EditKepengurusan::route('/{record}/edit'),
        ];
    }
}