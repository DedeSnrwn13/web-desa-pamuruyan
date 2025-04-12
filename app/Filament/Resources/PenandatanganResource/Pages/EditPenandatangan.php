<?php

namespace App\Filament\Resources\PenandatanganResource\Pages;

use App\Filament\Resources\PenandatanganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenandatangan extends EditRecord
{
    protected static string $resource = PenandatanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->hidden(fn($record) => $record->surat->status !== 'menunggu'),
        ];
    }
}