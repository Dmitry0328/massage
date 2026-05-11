<?php

namespace App\Filament\Resources\Reviews\Schemas;

use App\Models\Review;
use App\Models\Master;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('client_name')
                    ->label("Ім'я")
                    ->required()
                    ->maxLength(255),
                Select::make('master_id')
                    ->label('Майстер')
                    ->options(fn (): array => Master::query()->orderBy('sort_order')->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload(),
                TextInput::make('rating')
                    ->label('Оцінка')
                    ->numeric()
                    ->step(0.5)
                    ->minValue(0)
                    ->maxValue(5)
                    ->required(),
                Select::make('status')
                    ->label('Статус')
                    ->options(Review::statusOptions())
                    ->default(Review::STATUS_DRAFT)
                    ->required(),
                DateTimePicker::make('published_at')
                    ->label('Дата публікації')
                    ->native(false)
                    ->seconds(false),
                Textarea::make('text')
                    ->label('Текст відгуку')
                    ->rows(6)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
