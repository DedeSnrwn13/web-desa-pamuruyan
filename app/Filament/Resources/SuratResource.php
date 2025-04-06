<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surat;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SuratResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SuratResource\RelationManagers;

class SuratResource extends Resource
{
    protected static ?string $model = Surat::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Surat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('admin_id')
                    ->default(fn() => Auth::guard('admin')->id()),

                Select::make('warga_id')
                    ->placeholder('Pilih warga')
                    ->relationship('warga', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('jenis_surat_id')
                    ->placeholder('Pilih jenis surat')
                    ->relationship('jenisSurat', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak'
                    ])
                    ->required(),

                TextInput::make('keterangan_warga')
                    ->required()
                    ->maxLength(255),

                TextInput::make('keterangan_admin')
                    ->maxLength(255),

                TextInput::make('no_surat')
                    ->maxLength(255),

                DatePicker::make('tanggal_surat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                TextColumn::make('warga.nama')
                    ->label('Warga')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_surat')
                    ->searchable(),

                TextColumn::make('tanggal_surat')
                    ->date(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    }),

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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak'
                    ]),
                Tables\Filters\SelectFilter::make('jenis_surat')
                    ->relationship('jenisSurat', 'nama')
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
            'index' => Pages\ListSurats::route('/'),
            'edit' => Pages\EditSurat::route('/{record}/edit'),
        ];
    }
}