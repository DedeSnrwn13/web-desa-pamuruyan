<?php

namespace App\Filament\Resources\LampiranSuratResource\Pages;

use App\Filament\Resources\LampiranSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLampiranSurats extends ListRecords
{
    protected static string $resource = LampiranSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}