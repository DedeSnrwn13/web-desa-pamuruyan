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