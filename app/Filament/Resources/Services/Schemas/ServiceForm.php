<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Master;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('master_id')
                    ->label('Майстер')
                    ->options(fn (): array => Master::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('label')
                    ->label('Назва послуги')
                    ->required()
                    ->maxLength(255),
                TextInput::make('key')
                    ->label('Ключ')
                    ->helperText('Можна залишити порожнім, ключ створиться автоматично з назви.')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('duration_minutes')
                    ->label('Тривалість, хв')
                    ->numeric()
                    ->minValue(1)
                    ->default(60)
                    ->required(),
                TextInput::make('price')
                    ->label('Ціна, грн')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                TextInput::make('discount_percent')
                    ->label('Знижка, %')
                    ->helperText('Якщо 0, знижка на сайті не показується.')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0)
                    ->required(),
                Toggle::make('is_active')
                    ->label('Показувати на сайті')
                    ->default(true)
                    ->required(),
                Textarea::make('description')
                    ->label('Опис')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
