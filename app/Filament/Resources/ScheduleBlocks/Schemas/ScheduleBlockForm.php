<?php

namespace App\Filament\Resources\ScheduleBlocks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;

class ScheduleBlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('master_id')
                    ->label('Майстер')
                    ->relationship('master', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DatePicker::make('block_date')
                    ->label('Дата')
                    ->native(false)
                    ->required(),
                Toggle::make('is_full_day')
                    ->label('Заблокувати весь день')
                    ->default(false)
                    ->live(),
                TimePicker::make('start_time')
                    ->label('Початок')
                    ->seconds(false)
                    ->required(fn (Get $get): bool => ! $get('is_full_day'))
                    ->visible(fn (Get $get): bool => ! $get('is_full_day')),
                TimePicker::make('end_time')
                    ->label('Кінець')
                    ->seconds(false)
                    ->required(fn (Get $get): bool => ! $get('is_full_day'))
                    ->visible(fn (Get $get): bool => ! $get('is_full_day')),
                TextInput::make('note')
                    ->label('Причина / примітка')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }
}
