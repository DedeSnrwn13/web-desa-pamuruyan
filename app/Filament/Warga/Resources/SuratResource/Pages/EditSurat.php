<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Filament\Warga\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mutateFormDataBeforeFill(array $data): array
    {
        // Get all form field values for this surat
        $formFieldValues = $this->record->suratFieldValues()
            ->with('suratFormField')
            ->get();

        // Map the values to the form_fields array
        $data['form_fields'] = $formFieldValues->mapWithKeys(function ($fieldValue) {
            // For file type, return as array for Filament FileUpload
            if ($fieldValue->suratFormField->tipe === 'file' && $fieldValue->file_value) {
                return [$fieldValue->surat_form_field_id => [$fieldValue->file_value]];
            }

            return [$fieldValue->surat_form_field_id => $fieldValue->value];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $formFields = $data['form_fields'] ?? [];
        unset($data['form_fields']);

        return $data;
    }

    protected function afterSave(): void
    {
        $formFields = $this->data['form_fields'] ?? [];
        $this->record->saveFormFieldValues($formFields);
    }
}