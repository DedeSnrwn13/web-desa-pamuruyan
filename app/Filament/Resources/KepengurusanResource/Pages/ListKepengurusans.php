<?php

namespace App\Filament\Resources\KepengurusanResource\Pages;

use App\Filament\Resources\KepengurusanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKepengurusans extends ListRecords
{
    protected static string $resource = KepengurusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengurus'),
        ];
    }
}