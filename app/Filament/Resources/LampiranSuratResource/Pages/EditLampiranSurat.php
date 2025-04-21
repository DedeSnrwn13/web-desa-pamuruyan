<?php

namespace App\Filament\Resources\LampiranSuratResource\Pages;

use App\Filament\Resources\LampiranSuratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLampiranSurat extends EditRecord
{
    protected static string $resource = LampiranSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn($record) => $record->surat->status !== 'menunggu'),
        ];
    }
}