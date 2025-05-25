<?php

namespace App\Filament\Resources\KampungResource\Pages;

use App\Filament\Resources\KampungResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKampung extends EditRecord
{
    protected static string $resource = KampungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}