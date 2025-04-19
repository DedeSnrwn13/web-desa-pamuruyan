<?php

namespace App\Filament\Resources\SuratResource\Pages;

use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Filament\Resources\SuratResource;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class TinjauSurat extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithRecord;

    protected static string $resource = SuratResource::class;

    protected static string $view = 'filament.resources.surat-resource.pages.tinjau-surat';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        if ($this->record->status !== 'menunggu') {
            redirect()->to($this->getResource()::getUrl('index'));
        }

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
                        ->acceptedFileTypes(['application/pdf'])
                        ->uploadingMessage('Uploading file surat...')
                        ->required()
                        ->directory('surat-disetujui/' . $this->record->id)
                        ->getUploadedFileNameForStorageUsing(
                            fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
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
                            'status' => 'disetujui',
                            'no_surat' => $data['no_surat'],
                            'tanggal_surat' => $data['tanggal_surat'],
                            'file_surat' => $data['file_surat'],
                            'keterangan_admin' => $data['keterangan_admin']
                        ]);

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
                            'status' => 'ditolak',
                            'keterangan_admin' => $data['keterangan_admin']
                        ]);

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
}