<?php

namespace App\Filament\Resources\BeritaResource\Pages;

use Filament\Actions;
use App\Enum\BeritaStatus;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BeritaResource;

class EditBerita extends EditRecord
{
    protected static string $resource = BeritaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('publish')
                ->label('Publish')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn(): bool => $this->record->status !== BeritaStatus::PUBLISHED->name)
                ->action(function (): void {
                    $this->record->update([
                        'status' => BeritaStatus::PUBLISHED->name,
                        'tanggal_post' => now(),
                    ]);

                    Notification::make()
                        ->success()
                        ->title('Published successfully')
                        ->send();
                }),

            Actions\Action::make('pending')
                ->label('Set Pending')
                ->icon('heroicon-o-clock')
                ->color(color: 'gray')
                ->requiresConfirmation()
                ->visible(fn(): bool => $this->record->status !== BeritaStatus::PENDING->name)
                ->action(function (): void {
                    $this->record->update([
                        'status' => BeritaStatus::PENDING->name
                    ]);

                    Notification::make()
                        ->warning()
                        ->title('Set to pending')
                        ->send();
                }),

            Actions\Action::make('reject')
                ->label('Reject')
                ->icon('heroicon-o-x-circle')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn(): bool => $this->record->status !== BeritaStatus::REJECTED->name)
                ->action(function (): void {
                    $this->record->update([
                        'status' => BeritaStatus::REJECTED->name
                    ]);

                    Notification::make()
                        ->danger()
                        ->title('Rejected successfully')
                        ->send();
                }),

            Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation(),
        ];
    }
}