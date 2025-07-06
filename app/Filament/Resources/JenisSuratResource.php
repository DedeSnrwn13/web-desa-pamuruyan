<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\JenisSurat;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\JenisSuratResource\Pages;

class JenisSuratResource extends Resource
{
    protected static ?string $model = JenisSurat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Jenis Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jenis Surat')
                    ->description('Informasi detail jenis surat yang akan dipublikasikan')
                    ->schema([
                        Hidden::make('admin_id')
                            ->default(fn() => Auth::guard('admin')->id())
                            ->required(),

                        TextInput::make('nama')
                            ->placeholder('Masukkan nama jenis surat')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('kode')
                            ->placeholder('Masukkan kode jenis surat')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20),
                    ])->columns(2)
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

                TextColumn::make('kode')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('admin.nama')
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListJenisSurats::route('/'),
            'create' => Pages\CreateJenisSurat::route('/create'),
            'edit' => Pages\EditJenisSurat::route('/{record}/edit'),
        ];
    }
}