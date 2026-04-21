<?php

namespace App\Filament\Resources\BookingSettings\Pages;

use App\Filament\Resources\BookingSettings\BookingSettingResource;
use Filament\Resources\Pages\ListRecords;

class ListBookingSettings extends ListRecords
{
    protected static string $resource = BookingSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
