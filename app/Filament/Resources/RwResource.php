<?php

namespace App\Filament\Resources;

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
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\RwResource\Pages;

class RwResource extends Resource
{
    protected static ?string $model = Rw::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Desa';
    protected static ?string $navigationLabel = 'RW';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi RW')
                    ->description('Informasi RW yang akan ditambahkan')
                    ->icon('heroicon-o-user-group')
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
                            ->validationMessages([
                                'required' => 'Kampung wajib dipilih',
                            ]),

                        TextInput::make('no_rw')
                            ->label('Nomor RW')
                            ->placeholder('Masukkan nomor RW')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(999)
                            ->unique(
                                'rws',
                                'no_rw',
                                ignoreRecord: true,
                                modifyRuleUsing: fn(Unique $rule, $get) =>
                                $rule->where('kampung_id', $get('kampung_id'))
                            )
                            ->validationMessages([
                                'required' => 'Nomor RW wajib diisi',
                                'numeric' => 'Nomor RW harus berupa angka',
                                'min' => 'Nomor RW minimal 1',
                                'max' => 'Nomor RW maksimal 999',
                                'unique' => 'Nomor RW sudah digunakan di kampung ini',
                            ])
                            ->disabled(fn(Forms\Get $get) => !$get('kampung_id')),
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

                TextColumn::make('kampung.nama')
                    ->label('Kampung')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_rw')
                    ->label('Nomor RW')
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus RW')
                    ->modalDescription('Apakah Anda yakin ingin menghapus RW ini? Tindakan ini akan menghapus:
                    - Semua data RT dalam RW ini
                    - Semua data warga yang terdaftar dalam RT di RW ini')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus RW yang Dipilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus RW yang dipilih? Tindakan ini akan menghapus:
                        - Semua data RT dalam RW-RW ini
                        - Semua data warga yang terdaftar dalam RT di RW-RW ini')
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
            'index' => Pages\ListRws::route('/'),
            'create' => Pages\CreateRw::route('/create'),
            'edit' => Pages\EditRw::route('/{record}/edit'),
        ];
    }
}