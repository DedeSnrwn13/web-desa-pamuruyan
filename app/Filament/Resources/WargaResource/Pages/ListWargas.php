<?php

namespace App\Filament\Resources\WargaResource\Pages;

use App\Filament\Resources\WargaResource;
use Filament\Resources\Pages\ListRecords;

class ListWargas extends ListRecords
{
    protected static string $resource = WargaResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}