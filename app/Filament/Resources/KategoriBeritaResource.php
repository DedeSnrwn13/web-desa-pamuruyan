<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\KategoriBerita;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KategoriBeritaResource\Pages;
use App\Filament\Resources\KategoriBeritaResource\RelationManagers;

class KategoriBeritaResource extends Resource
{
    protected static ?string $model = KategoriBerita::class;

    protected static ?string $navigationLabel = 'Kategori';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manajemen Berita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kategori')
                    ->description('Kategori berita yang akan ditampilkan di halaman berita')
                    ->schema([
                        Forms\Components\Hidden::make('admin_id')
                            ->default(fn() => Auth::guard('admin')->id())
                            ->required(),

                        TextInput::make('nama')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->minLength(3)
                            ->maxLength(150),

                        TextInput::make('slug')
                            ->required()
                            ->unique(KategoriBerita::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)
                            ->disabled()
                            ->dehydrated()
                    ])
                    ->columns(2)
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

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('admin.name')
                    ->label('Dibuat oleh'),

                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
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
            'index' => Pages\ListKategoriBeritas::route('/'),
            'create' => Pages\CreateKategoriBerita::route('/create'),
            'edit' => Pages\EditKategoriBerita::route('/{record}/edit'),
        ];
    }
}