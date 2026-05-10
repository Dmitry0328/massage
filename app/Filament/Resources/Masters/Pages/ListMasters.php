<?php

namespace App\Filament\Resources\Masters\Pages;

use App\Filament\Resources\Masters\MasterResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMasters extends ListRecords
{
    protected static string $resource = MasterResource::class;

    public function mount(): void
    {
        parent::mount();

        Notification::make()
            ->title('!Бажано не змінювати данні!')
            ->body('Цей розділ впливає на запис клієнтів на сайті.')
            ->warning()
            ->persistent()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
