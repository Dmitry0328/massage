<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Master;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
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
                Select::make('category')
                    ->label('Тема')
                    ->options([
                        'Апаратні масажі' => 'Апаратні масажі',
                    ])
                    ->placeholder('Звичайна послуга')
                    ->helperText('Для Міостимуляції, Кавітації, RF-ліфтингу, Вакуумного масажу та Пресотерапії оберіть тему “Апаратні масажі”.'),
                TextInput::make('key')
                    ->label('Ключ')
                    ->helperText('Можна залишити порожнім, ключ створиться автоматично з назви.')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('duration_minutes')
                    ->label('Тривалість, хв')
                    ->helperText('Для апаратних масажів залиште 60 хв: клієнт сам обере 15/30/45/60 хв у формі.')
                    ->numeric()
                    ->minValue(1)
                    ->default(60)
                    ->required(),
                TextInput::make('price')
                    ->label(fn (Get $get): string => $get('is_price_per_minute') ? 'Ціна за 1 хв, грн' : 'Ціна, грн')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
                Toggle::make('is_price_per_minute')
                    ->label('Ціна за 1 хвилину')
                    ->helperText('Увімкніть для апаратних масажів. На сайті буде показано “1 хв - ціна грн”.')
                    ->default(false)
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
