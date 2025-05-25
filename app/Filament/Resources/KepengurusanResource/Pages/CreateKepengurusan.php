<?php

namespace App\Filament\Resources\KepengurusanResource\Pages;

use App\Filament\Resources\KepengurusanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKepengurusan extends CreateRecord
{
    protected static string $resource = KepengurusanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}