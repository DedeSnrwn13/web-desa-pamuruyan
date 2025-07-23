<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surat;
use Filament\Forms\Form;
use App\Enum\SuratStatus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SuratResource\Pages;
use Filament\Notifications\Actions\Action as NotificationAction;

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
                Forms\Components\Section::make('Informasi Berita')
                    ->description('Informasi detail surat yang akan dipublikasikan')
                    ->schema([
                        Hidden::make('admin_id')
                            ->default(fn() => Auth::guard('admin')->id()),

                        Select::make('warga_id')
                            ->placeholder('Pilih warga')
                            ->relationship('warga', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        Select::make('jenis_surat_id')
                            ->placeholder('Pilih jenis surat')
                            ->relationship('jenisSurat', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        Select::make('status')
                            ->options([
                                'menunggu' => 'Menunggu',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak'
                            ])
                            ->placeholder('Pilih status surat')
                            ->required()
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        TextInput::make('keterangan_warga')
                            ->placeholder('Masukkan keterangan warga')
                            ->required()
                            ->maxLength(255)
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        TextInput::make('keterangan_admin')
                            ->maxLength(255)
                            ->placeholder('Masukkan keterangan admin')
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        TextInput::make('no_surat')
                            ->maxLength(255)
                            ->placeholder('Masukkan nomor surat')
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),

                        DatePicker::make('tanggal_surat')
                            ->placeholder('Pilih tanggal surat')
                            ->disabled(fn($record) => $record?->status !== SuratStatus::MENUNGGU->value),
                    ])->columns(2),
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
                        'ditinjau' => 'info',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => SuratStatus::from($state)->label()),

                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('admin.name')
                    ->label(label: 'Di setujui/ditolak oleh')
                    ->default(fn($record) => $record?->admin?->name ?? '-'),
            ])
            ->defaultSort('created_at', 'asc')
            ->modifyQueryUsing(
                fn(Builder $query) => $query
                    ->orderByRaw("FIELD(status, 'ditinjau', 'menunggu', 'disetujui', 'ditolak')")
                    ->orderBy('created_at', direction: 'asc')
            )
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'ditinjau' => 'Sedang Ditinjau',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak'
                    ]),
                Tables\Filters\SelectFilter::make('jenis_surat')
                    ->relationship('jenisSurat', 'nama')
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->hidden(fn($record) => $record?->status !== 'menunggu'),

                Tables\Actions\Action::make('tinjau')
                    ->label(fn($record) => $record->status === SuratStatus::DITINJAU->value ? 'Sedang Ditinjau' : 'Tinjau')
                    ->icon('heroicon-o-eye')
                    ->color(fn($record) => $record->status === SuratStatus::DITINJAU->value ? 'info' : 'warning')
                    ->url(fn(Surat $record): string => static::getUrl('tinjau', ['record' => $record]))
                    ->visible(function ($record) {
                        // Jika surat ini sedang ditinjau, tampilkan button
                        if ($record->status === SuratStatus::DITINJAU->value) {
                            return true;
                        }

                        // Jika surat ini menunggu
                        if ($record->status === SuratStatus::MENUNGGU->value) {
                            // Ambil ID surat menunggu paling awal
                            $firstWaitingId = Surat::where('status', SuratStatus::MENUNGGU->value)
                                ->orderBy('created_at', 'asc')
                                ->value('id');

                            // Tampilkan button hanya jika ini adalah surat menunggu paling awal
                            return $record->id === $firstWaitingId;
                        }

                        return false;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

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
            'tinjau' => Pages\TinjauSurat::route('/{record}/tinjau'),
        ];
    }
}