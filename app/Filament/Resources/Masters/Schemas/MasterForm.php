<?php

namespace App\Filament\Resources\Masters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MasterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('ПІБ майстра')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Номер телефону')
                    ->tel()
                    ->maxLength(255),
            ]);
    }
}
