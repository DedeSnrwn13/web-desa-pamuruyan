<?php

namespace App\Filament\Resources\KepengurusanResource\Pages;

use App\Filament\Resources\KepengurusanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKepengurusan extends EditRecord
{
    protected static string $resource = KepengurusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Pengurus')
                ->modalDescription('Apakah Anda yakin ingin menghapus data pengurus ini?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}