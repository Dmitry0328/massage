<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label('Тривалість')
                    ->suffix(' хв')
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('price')
                    ->label('Ціна')
                    ->money('UAH')
                    ->sortable(),
                TextColumn::make('discount_percent')
                    ->label('Знижка')
                    ->formatStateUsing(fn (int $state): string => $state > 0 ? "-{$state}%" : 'Без знижки')
                    ->sortable()
                    ->visibleFrom('md'),
                IconColumn::make('is_active')
                    ->label('На сайті')
                    ->boolean()
                    ->visibleFrom('lg'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
