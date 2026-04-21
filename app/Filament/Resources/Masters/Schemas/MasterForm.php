<?php

namespace App\Filament\Resources\Masters\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MasterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label("Ім'я")
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('Slug')
                    ->helperText('Можна залишити порожнім, slug згенерується автоматично.')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Активний')
                    ->default(true)
                    ->required(),
                Textarea::make('bio')
                    ->label('Опис')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
