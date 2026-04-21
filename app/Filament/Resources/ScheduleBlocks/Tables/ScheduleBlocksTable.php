<?php

namespace App\Filament\Resources\ScheduleBlocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ScheduleBlocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('block_date')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable(),
                IconColumn::make('is_full_day')
                    ->label('Весь день')
                    ->boolean(),
                TextColumn::make('start_time')
                    ->label('Початок')
                    ->time('H:i')
                    ->placeholder('Весь день'),
                TextColumn::make('end_time')
                    ->label('Кінець')
                    ->time('H:i')
                    ->placeholder('Весь день'),
                TextColumn::make('note')
                    ->label('Примітка')
                    ->wrap()
                    ->limit(40),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('block_date', 'desc');
    }
}
