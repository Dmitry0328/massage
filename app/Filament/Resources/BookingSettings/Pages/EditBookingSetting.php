<?php

namespace App\Filament\Resources\BookingSettings\Pages;

use App\Filament\Resources\BookingSettings\BookingSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditBookingSetting extends EditRecord
{
    protected static string $resource = BookingSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
