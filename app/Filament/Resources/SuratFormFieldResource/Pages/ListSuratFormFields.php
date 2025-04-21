<?php

namespace App\Filament\Resources\SuratFormFieldResource\Pages;

use App\Filament\Resources\SuratFormFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuratFormFields extends ListRecords
{
    protected static string $resource = SuratFormFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
