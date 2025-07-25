<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Models\Admin;
use App\Enum\SuratStatus;
use App\Models\JenisSurat;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Warga\Resources\SuratResource;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification as FilamentNotification;

class CreateSurat extends CreateRecord
{
    protected static string $resource = SuratResource::class;

    public function mount(): void
    {
        parent::mount();

        $kode = request()->query('kode-surat');
        if ($kode) {
            $jenisSurat = JenisSurat::where('kode', $kode)->first();
            if ($jenisSurat) {
                $this->form->fill([
                    'jenis_surat_id' => $jenisSurat->id,
                    'warga_id' => Auth::guard('warga')->id()
                ]);
            }
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $formFields = $data['form_fields'] ?? [];
        unset($data['form_fields']);

        $data['warga_id'] = Auth::guard('warga')->id();
        $data['status'] = SuratStatus::MENUNGGU->value;
        return $data;
    }

    protected function afterCreate(): void
    {
        // Get form fields data
        $formFields = $this->data['form_fields'] ?? [];

        // Get the jenis surat to access form field definitions
        $jenisSurat = $this->record->jenisSurat;
        $formFieldDefinitions = $jenisSurat->suratFormFields()->get();

        // Process each form field
        foreach ($formFields as $fieldId => $value) {
            if (empty($value))
                continue;

            $fieldDefinition = $formFieldDefinitions->firstWhere('id', $fieldId);
            if (!$fieldDefinition)
                continue;
        }

        // Save all form field values
        $this->record->saveFormFieldValues($formFields);

        // Send notification to all admins
        $admins = Admin::all();
        foreach ($admins as $admin) {
            FilamentNotification::make()
                ->title('Pengajuan Surat Baru')
                ->info()
                ->body("Surat {$this->record->jenisSurat->nama} telah diajukan oleh {$this->record->warga->nama}")
                ->actions([
                    NotificationAction::make('view')
                        ->label('Tinjau')
                        ->url(fn(): string => route('filament.admin.resources.surats.tinjau', $this->record))
                        ->button()
                        ->markAsRead()
                ])
                ->sendToDatabase($admin, isEventDispatched: true);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}