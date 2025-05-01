<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Filament\Warga\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSurat extends ViewRecord
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn() => $this->record->status === 'menunggu'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $formFields = [];
        foreach ($this->record->suratFieldValues as $fieldValue) {
            $formFields[$fieldValue->surat_form_field_id] = $fieldValue->value;
        }
        $data['form_fields'] = $formFields;

        return $data;
    }
} 