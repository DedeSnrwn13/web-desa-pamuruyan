<?php

namespace App\Filament\Resources\SuratResource\Pages;

use Filament\Forms\Form;
use App\Enum\SuratStatus;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\SuratResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action as NotificationAction;

class TinjauSurat extends Page implements HasForms, HasTable, HasInfolists, HasActions
{
    use InteractsWithForms, InteractsWithRecord, InteractsWithTable, InteractsWithInfolists;

    protected static string $resource = SuratResource::class;

    protected static string $view = 'filament.resources.surat-resource.pages.tinjau-surat';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        if ($this->record->status !== SuratStatus::MENUNGGU->value) {
            redirect()->to($this->getResource()::getUrl('index'));
        }

        $this->record->load(['suratFieldValues.suratFormField']);

        $this->form->fill([
            'warga' => [
                'nama' => $this->record->warga->nama,
                'rt' => [
                    'kampung' => [
                        'nama' => $this->record->warga->rt->kampung->nama,
                    ],
                    'no_rt' => $this->record->warga->rt->no_rt,
                    'rw' => [
                        'no_rw' => $this->record->warga->rt->rw->no_rw,
                    ],
                ],
            ],
            'jenis_surat' => [
                'nama' => $this->record->jenisSurat->nama,
            ],
            'keterangan_warga' => $this->record->keterangan_warga,
            'keterangan_admin' => $this->record->keterangan_admin,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Informasi Warga')
                            ->schema([
                                TextInput::make('warga.nama')
                                    ->label('Nama Warga')
                                    ->disabled(),

                                TextInput::make('warga.rt.kampung.nama')
                                    ->label('Kampung')
                                    ->disabled(),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('warga.rt.no_rt')
                                            ->label('RT')
                                            ->disabled(),

                                        TextInput::make('warga.rt.rw.no_rw')
                                            ->label('RW')
                                            ->disabled(),
                                    ]),
                            ])
                            ->columnSpan(1),

                        Section::make('Informasi Surat')
                            ->schema([
                                TextInput::make('jenis_surat.nama')
                                    ->label('Jenis Surat')
                                    ->disabled(),

                                Textarea::make('keterangan_warga')
                                    ->label('Keterangan dari Warga')
                                    ->disabled()
                                    ->rows(3),

                                Textarea::make('keterangan_admin')
                                    ->label('Keterangan Admin')
                                    ->placeholder('Masukkan keterangan, kenapa disetujui atau ditolak')
                                    ->required()
                                    ->rows(3)
                                    ->minLength(10)
                                    ->maxLength(255)
                                    ->disabled(),
                            ])
                            ->columnSpan(1),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('setujui')
                ->label('Setujui')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    TextInput::make('no_surat')
                        ->label('Nomor Surat')
                        ->required()
                        ->placeholder('Masukkan nomor surat')
                        ->maxLength(255),

                    DatePicker::make('tanggal_surat')
                        ->label('Tanggal Surat')
                        ->required()
                        ->default(now()),

                    FileUpload::make('file_surat')
                        ->label('Upload File Surat')
                        ->required()
                        ->directory('surat-disetujui')
                        ->acceptedFileTypes([
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-word.document.macroEnabled.12',
                            'application/vnd.ms-word.template.macroEnabled.12',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                        ])
                        ->helperText('Surat harus berformat PDF atau Word')
                        ->mimeTypeMap([
                            'application/pdf' => 'PDF',
                            'application/msword' => 'Word',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word',
                            'application/vnd.ms-word.document.macroEnabled.12' => 'Word (Macro-Enabled)',
                            'application/vnd.ms-word.template.macroEnabled.12' => 'Word Template (Macro-Enabled)',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => 'Word Template',
                        ])
                        ->uploadingMessage('Uploading file surat...')
                        ->required()
                        ->directory('surat-disetujui/' . $this->record->id)
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => date('Y-m-d-H-i-s') . '-' . (string) str($file->getClientOriginalName())
                                ->prepend('surat-disetujui-'),
                        )
                        ->maxSize(5120),

                    Textarea::make('keterangan_admin')
                        ->label('Keterangan Persetujuan')
                        ->placeholder('Masukkan keterangan kenapa surat disetujui')
                        ->required()
                        ->minLength(10)
                        ->maxLength(255)
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    try {
                        $this->record->update([
                            'admin_id' => Auth::guard('admin')->id(),
                            'status' => SuratStatus::DISETUJUI->value,
                            'no_surat' => $data['no_surat'],
                            'tanggal_surat' => $data['tanggal_surat'],
                            'file_surat' => $data['file_surat'],
                            'keterangan_admin' => $data['keterangan_admin']
                        ]);

                        // Send notification to warga
                        $warga = $this->record->warga;
                        Notification::make()
                            ->title('Status Surat Diperbarui')
                            ->success()
                            ->body("Surat {$this->record->jenisSurat->nama} telah disetujui. Silakan download surat Anda.")
                            ->actions([
                                NotificationAction::make('view')
                                    ->label('Lihat')
                                    ->button()
                                    ->url(fn(): string => route('filament.warga.resources.surats.view', $this->record))
                                    ->markAsRead()
                            ])
                            ->sendToDatabase($warga, isEventDispatched: true);

                        Notification::make()
                            ->success()
                            ->title('Surat berhasil disetujui')
                            ->send();

                        redirect()->to($this->getResource()::getUrl('index'));
                    } catch (\Exception $e) {
                        Log::error($e);
                        Notification::make()
                            ->danger()
                            ->title('Gagal menyetujui surat')
                            ->body('Terjadi kesalahan saat memproses surat')
                            ->send();
                    }
                }),

            Action::make('tolak')
                ->label('Tolak')
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    Textarea::make('keterangan_admin')
                        ->label('Keterangan Penolakan')
                        ->placeholder('Masukkan keterangan kenapa surat ditolak')
                        ->required()
                        ->minLength(10)
                        ->maxLength(255)
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    try {
                        $this->record->update([
                            'admin_id' => Auth::guard('admin')->id(),
                            'status' => SuratStatus::DITOLAK->value,
                            'keterangan_admin' => $data['keterangan_admin']
                        ]);

                        // Send notification to warga
                        $warga = $this->record->warga;
                        Notification::make()
                            ->title('Status Surat Diperbarui')
                            ->danger()
                            ->body("Surat {$this->record->jenisSurat->nama} ditolak dengan alasan: {$data['keterangan_admin']}")
                            ->actions([
                                NotificationAction::make('view')
                                    ->label('Lihat')
                                    ->url(fn(): string => route('filament.warga.resources.surats.view', $this->record))
                                    ->button()
                                    ->markAsRead()
                            ])
                            ->sendToDatabase($warga, isEventDispatched: true);

                        Notification::make()
                            ->success()
                            ->title('Surat berhasil ditolak')
                            ->send();

                        redirect()->to($this->getResource()::getUrl('index'));
                    } catch (\Exception $e) {
                        Log::error($e);
                        Notification::make()
                            ->danger()
                            ->title('Gagal menolak surat')
                            ->body('Terjadi kesalahan saat memproses surat')
                            ->send();
                    }
                }),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn(): HasMany => $this->record->suratFieldValues())
            ->columns([
                TextColumn::make('suratFormField.label')
                    ->label('Label')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Nilai')
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->suratFormField->tipe === 'date') {
                            return $state?->format('d/m/Y');
                        } elseif ($record->suratFormField->tipe === 'select') {
                            return $record->select_value;
                        } elseif ($record->suratFormField->tipe === 'number') {
                            return $record->number_value;
                        } elseif ($record->suratFormField->tipe === 'text') {
                            return $record->text_value;
                        }
                        return $state;
                    }),
                TextColumn::make('suratFormField.group')
                    ->label('Grup')
                    ->sortable(),
            ])
            ->defaultGroup('suratFormField.group')
            ->modifyQueryUsing(
                fn($query) => $query->join('surat_form_fields', 'surat_field_values.surat_form_field_id', '=', 'surat_form_fields.id')
                    ->orderBy('surat_form_fields.urutan', 'asc')
            );
    }
}