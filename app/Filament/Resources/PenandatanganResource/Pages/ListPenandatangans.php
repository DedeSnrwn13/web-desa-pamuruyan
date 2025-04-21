<?php

namespace App\Filament\Resources\PenandatanganResource\Pages;

use App\Filament\Resources\PenandatanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenandatangans extends ListRecords
{
    protected static string $resource = PenandatanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}