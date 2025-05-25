<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Admin;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\AdminResource\Pages;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?string $navigationLabel = 'Admin';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Admin')
                    ->description('Informasi detail admin')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('username')
                            ->label('Username')
                            ->placeholder('Masukkan Username Admin')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        TextInput::make('nama')
                            ->label('Nama')
                            ->placeholder('Masukkan Nama Admin')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->placeholder('Masukkan Jabatan Admin')
                            ->required()
                            ->maxLength(100),

                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Masukkan Email Admin')
                            ->email()
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),

                        TextInput::make('password')
                            ->label('Password')
                            ->placeholder('Masukkan Password Admin')
                            ->password()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->same('password_confirmation')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state)),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->placeholder('Masukkan Konfirmasi Password Admin')
                            ->password()
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->dehydrated(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),

                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_login')
                    ->label('Login Terakhir')
                    ->dateTime()
                    ->sortable(),

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
                Tables\Actions\EditAction::make()
                    ->visible(
                        fn(Model $record) =>
                        // Admin dengan ID 1 hanya bisa diedit oleh dirinya sendiri
                        $record->id === 1 ? Auth::guard('admin')->id() === 1 : true
                    ),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Admin')
                    ->modalDescription(fn(Model $record) => "Apakah Anda yakin ingin menghapus admin ini? Tindakan ini akan menghapus:
                        - Semua data kampung yang dibuat oleh admin ini
                        - Semua data RW yang dibuat oleh admin ini
                        - Semua data RT yang dibuat oleh admin ini
                        - Semua data berita yang dibuat oleh admin ini
                        - Semua data jenis surat yang dibuat oleh admin ini
                        - Semua data surat yang diproses oleh admin ini
                        - Semua data inventaris yang dikelola oleh admin ini
                        - Semua data keuangan yang dicatat oleh admin ini
                        - Semua data jadwal yang dibuat oleh admin ini")
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->visible(
                        fn(Model $record) =>
                        // Admin dengan ID 1 tidak bisa dihapus
                        // Admin tidak bisa menghapus dirinya sendiri
                        $record->id !== 1 && $record->id !== Auth::guard('admin')->id()
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Admin yang Dipilih')
                        ->modalDescription("Apakah Anda yakin ingin menghapus admin yang dipilih? Tindakan ini akan menghapus:
                            - Semua data kampung yang dibuat oleh admin-admin ini
                            - Semua data RW yang dibuat oleh admin-admin ini
                            - Semua data RT yang dibuat oleh admin-admin ini
                            - Semua data berita yang dibuat oleh admin-admin ini
                            - Semua data jenis surat yang dibuat oleh admin-admin ini
                            - Semua data surat yang diproses oleh admin-admin ini
                            - Semua data inventaris yang dikelola oleh admin-admin ini
                            - Semua data keuangan yang dicatat oleh admin-admin ini
                            - Semua data jadwal yang dibuat oleh admin-admin ini")
                        ->modalSubmitActionLabel('Ya, Hapus Semua')
                        ->modalCancelActionLabel('Batal')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                // Skip jika admin dengan ID 1 atau admin yang sedang login
                                if ($record->id !== 1 && $record->id !== Auth::guard('admin')->id()) {
                                    $record->delete();
                                }
                            });
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}