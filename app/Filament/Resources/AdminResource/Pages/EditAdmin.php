<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(
                    fn() =>
                    // Admin dengan ID 1 tidak bisa dihapus
                    // Admin tidak bisa menghapus dirinya sendiri
                    $this->record->id !== 1 && $this->record->id !== Auth::guard('admin')->id()
                ),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        // Jika yang diedit adalah admin yang sedang login
        if ($this->record->id === Auth::guard('admin')->id()) {
            // Perbarui session dengan data terbaru
            Auth::guard('admin')->login($this->record);
        }
    }
}