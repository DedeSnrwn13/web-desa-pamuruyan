<?php

namespace App\Filament\Warga\Resources\SuratResource\Pages;

use App\Filament\Warga\Resources\SuratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurats extends ListRecords
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 