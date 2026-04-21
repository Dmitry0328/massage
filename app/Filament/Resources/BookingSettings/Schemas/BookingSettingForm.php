<?php

namespace App\Filament\Resources\BookingSettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('max_advance_months')
                    ->label('Максимум місяців наперед')
                    ->helperText('Наприклад, значення 2 дозволяє бронювати максимум на 2 місяці вперед.')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(12)
                    ->required(),
            ]);
    }
}
