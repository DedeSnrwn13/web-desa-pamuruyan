<?php

namespace App\Filament\Resources\KampungResource\Pages;

use App\Filament\Resources\KampungResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKampungs extends ListRecords
{
    protected static string $resource = KampungResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}