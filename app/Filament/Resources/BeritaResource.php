<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Berita;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Enum\BeritaStatus;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\BeritaResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Manajemen Berita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita')
                    ->description('Informasi detail berita yang akan dipublikasikan')
                    ->schema([
                        Hidden::make('admin_id')
                            ->default(fn() => Auth::guard('admin')->id())
                            ->required(),

                        TextInput::make('judul')
                            ->required()
                            ->placeholder('Input judul')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->minLength(5)
                            ->maxLength(255),

                        Hidden::make('slug')
                            ->required()
                            ->unique(Berita::class, 'slug', ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),

                        Select::make('kategori_berita_id')
                            ->relationship('kategoriBerita', 'nama')
                            ->placeholder('Pilih kategori berita')
                            ->required()
                            ->searchable()
                            ->preload(),

                        RichEditor::make('isi')
                            ->required()
                            ->placeholder('Input isi berita')
                            ->minLength(15)
                            ->columnSpanFull(),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->uploadingMessage('Uploading thumbnail...')
                            ->required()
                            ->directory('thumbnails')
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) date('Y-m-d-H-i-s') . '-' . str($file->getClientOriginalName())
                                    ->prepend('berita-'),
                            )
                            ->columnSpanFull()
                            ->maxSize(size: 5120),

                        Hidden::make('status')
                            ->default(BeritaStatus::PENDING->name)
                            ->required(),
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

                TextColumn::make('judul')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kategoriBerita.nama')
                    ->searchable(),

                ImageColumn::make('thumbnail')
                    ->square(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'REJECTED' => 'danger',
                        'PENDING' => 'warning',
                        'PUBLISHED' => 'success',
                        default => 'secondary',
                    }),

                TextColumn::make('tanggal_post')
                    ->label('Tanggal Posting')
                    ->dateTime()
                    ->placeholder('-')
                    ->formatStateUsing(fn($state) => $state ?? '-')
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'PENDING' => 'Pending',
                        'PUBLISHED' => 'Published',
                        'REJECTED' => 'Rejected'
                    ]),

                Tables\Filters\SelectFilter::make('kategori')
                    ->relationship('kategoriBerita', 'nama'),
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}