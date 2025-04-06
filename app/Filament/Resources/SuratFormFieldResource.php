<?php

namespace App\Filament\Resources;


use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SuratFormField;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SuratFormFieldResource\Pages;
use App\Filament\Resources\SuratFormFieldResource\RelationManagers;

class SuratFormFieldResource extends Resource
{
    protected static ?string $model = SuratFormField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manajemen Surat';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Input Form';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('jenis_surat_id')
                    ->relationship('jenisSurat', 'nama')
                    ->placeholder('Pilih jenis surat')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(),

                TextInput::make('nama_field')
                    ->placeholder('Masukkan nama input')
                    ->required()
                    ->maxLength(100)
                    ->unique(
                        table: 'surat_form_fields',
                        column: 'nama_field',
                        ignorable: fn($record) => $record,
                        modifyRuleUsing: function (Unique $rule, Get $get) {
                            return $rule->where('jenis_surat_id', $get('jenis_surat_id'));
                        }
                    ),

                TextInput::make('label')
                    ->placeholder('Masukkan label input')
                    ->required()
                    ->maxLength(100),

                Select::make('tipe')
                    ->placeholder('Pilih tipe input')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Text Area',
                        'number' => 'Number',
                        'date' => 'Date',
                        'select' => 'Select'
                    ])
                    ->required(),

                Textarea::make('opsi')
                    ->helperText('Masukkan opsi dipisahkan dengan koma (,) jika tipe adalah select')
                    ->visible(fn(Forms\Get $get) => $get('tipe') === 'select'),

                Toggle::make('is_required')
                    ->inline(false)
                    ->label('Wajib diisi')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(false),

                TextInput::make('urutan')
                    ->placeholder('Masukkan urutan input')
                    ->numeric()
                    ->required()
                    ->unique(
                        table: 'surat_form_fields',
                        column: 'urutan',
                        ignorable: fn($record) => $record,
                        modifyRuleUsing: function (Unique $rule, Get $get) {
                            return $rule->where('jenis_surat_id', $get('jenis_surat_id'));
                        }
                    ),

                TextInput::make('group')
                    ->placeholder('Masukkan group input')
                    ->maxLength(150)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make(name: '#')
                    ->rowIndex(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_field')
                    ->label('Nama Input')
                    ->searchable(),

                TextColumn::make('label')
                    ->searchable(),

                TextColumn::make('tipe')
                    ->badge(),

                IconColumn::make('is_required')
                    ->label('Wajib diisi')
                    ->boolean(),

                TextColumn::make('urutan')
                    ->sortable(),

                TextColumn::make('group')
                    ->label('Grup')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),

            ])
            ->filters([
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
            ])
            ->defaultSort('urutan');
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
            'index' => Pages\ListSuratFormFields::route('/'),
            'create' => Pages\CreateSuratFormField::route('/create'),
            'edit' => Pages\EditSuratFormField::route('/{record}/edit'),
        ];
    }
}