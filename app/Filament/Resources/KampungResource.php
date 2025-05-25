<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kampung;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\KampungResource\Pages;

class KampungResource extends Resource
{
    protected static ?string $model = Kampung::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?string $navigationLabel = 'Kampung';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kampung')
                    ->description('Informasi kampung yang akan ditambahkan')
                    ->icon('heroicon-o-home')
                    ->schema([
                        Hidden::make('admin_id')
                            ->default(Auth::guard('admin')->id())
                            ->required(),

                        TextInput::make('nama')
                            ->label('Nama Kampung')
                            ->placeholder('Masukkan nama kampung')
                            ->required()
                            ->maxLength(255),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),

                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('admin.name')
                    ->label('Dibuat Oleh'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
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
                    ->modalHeading('Hapus Kampung')
                    ->modalDescription('Apakah Anda yakin ingin menghapus kampung ini? Tindakan ini akan menghapus:
                    - Semua data RW dalam kampung ini
                    - Semua data RT dalam kampung ini
                    - Semua data warga yang terdaftar dalam RT di kampung ini')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Kampung yang Dipilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus kampung yang dipilih? Tindakan ini akan menghapus:
                        - Semua data RW dalam kampung-kampung ini
                        - Semua data RT dalam kampung-kampung ini
                        - Semua data warga yang terdaftar dalam RT di kampung-kampung ini')
                        ->modalSubmitActionLabel('Ya, Hapus Semua')
                        ->modalCancelActionLabel('Batal'),
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
            'index' => Pages\ListKampungs::route('/'),
            'create' => Pages\CreateKampung::route('/create'),
            'edit' => Pages\EditKampung::route('/{record}/edit'),
        ];
    }
}