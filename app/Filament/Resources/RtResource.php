<?php

namespace App\Filament\Resources;

use App\Models\Rt;
use App\Models\Rw;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Validation\Rules\Unique;
use App\Filament\Resources\RtResource\Pages;

class RtResource extends Resource
{
    protected static ?string $model = Rt::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Desa';

    protected static ?string $navigationLabel = 'RT';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi RT')
                    ->description('Informasi RT yang akan ditambahkan')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Hidden::make('admin_id')
                            ->default(Auth::guard('admin')->id())
                            ->required(),

                        Select::make('kampung_id')
                            ->label('Kampung')
                            ->placeholder('Pilih kampung')
                            ->relationship('kampung', 'nama')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->afterStateUpdated(fn(Forms\Set $set) => $set('rw_id', null)),

                        Select::make('rw_id')
                            ->label('RW')
                            ->placeholder('Pilih RW')
                            ->options(function (Forms\Get $get) {
                                $kampungId = $get('kampung_id');
                                if (!$kampungId) {
                                    return [];
                                }
                                return Rw::where('kampung_id', $kampungId)
                                    ->pluck('no_rw', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required()
                            ->disabled(fn(Forms\Get $get) => !$get('kampung_id')),

                        TextInput::make('no_rt')
                            ->label('Nomor RT')
                            ->placeholder('Masukkan nomor RT')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(999)
                            ->unique(
                                'rts',
                                'no_rt',
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule, $get) =>
                                $rule->where('rw_id', $get('rw_id'))
                            )
                            ->validationMessages([
                                'required' => 'Nomor RT wajib diisi',
                                'numeric' => 'Nomor RT harus berupa angka',
                                'min' => 'Nomor RT minimal 1',
                                'max' => 'Nomor RT maksimal 999',
                                'unique' => 'Nomor RT sudah digunakan di RW ini',
                            ])
                            ->disabled(fn(Forms\Get $get) => !$get('rw_id')),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),

                TextColumn::make('kampung.nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rw.no_rw')
                    ->label('Nomor RW')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_rt')
                    ->label('Nomor RT')
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
                SelectFilter::make('kampung_id')
                    ->label('Kampung')
                    ->placeholder('Pilih kampung')
                    ->relationship('kampung', 'nama')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('rw_id')
                    ->label('RW')
                    ->placeholder('Pilih RW')
                    ->relationship('rw', 'no_rw')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus RT')
                    ->modalDescription('Apakah Anda yakin ingin menghapus RT ini? Tindakan ini akan menghapus:
                    - Semua data warga yang terdaftar dalam RT ini
                    - Semua data surat dan notifikasi terkait warga RT ini')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus RT yang Dipilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus RT yang dipilih? Tindakan ini akan menghapus:
                        - Semua data warga yang terdaftar dalam RT-RT ini
                        - Semua data surat dan notifikasi terkait warga RT-RT ini')
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
            'index' => Pages\ListRts::route('/'),
            'create' => Pages\CreateRt::route('/create'),
            'edit' => Pages\EditRt::route('/{record}/edit'),
        ];
    }
}