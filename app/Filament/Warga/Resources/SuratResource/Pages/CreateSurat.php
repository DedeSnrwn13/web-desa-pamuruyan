<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Models\JenisSurat;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Warga\Resources\SuratResource;

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
                    'jenis_surat_id' => $jenisSurat->id
                ]);
            }
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $formFields = $data['form_fields'] ?? [];
        unset($data['form_fields']);

        $data['status'] = 'menunggu';
        return $data;
    }

    protected function afterCreate(): void
    {
        $formFields = $this->data['form_fields'] ?? [];
        $this->record->saveFormFieldValues($formFields);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 