<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                TextColumn::make('category')
                    ->label('Тема')
                    ->placeholder('—')
                    ->toggleable()
                    ->visibleFrom('md'),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('duration_minutes')
                    ->label('Тривалість')
                    ->formatStateUsing(fn (int $state, $record): string => $record->is_price_per_minute ? 'Обирає клієнт' : "{$state} хв")
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('price')
                    ->label('Ціна')
                    ->formatStateUsing(fn (int $state, $record): string => $record->is_price_per_minute ? "1 хв - {$state} грн" : number_format($state, 0, ',', ' ') . ' грн')
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
                ViewAction::make(),
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
