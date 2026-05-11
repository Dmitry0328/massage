<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        Review::purgeExpiredTrash();

        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->label("Ім'я")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->placeholder('—')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Оцінка')
                    ->formatStateUsing(fn (string|float $state): string => number_format((float) $state, 1, '.', '') . ' ★')
                    ->sortable(),
                TextColumn::make('text')
                    ->label('Відгук')
                    ->limit(90)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Review::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Review::STATUS_PUBLISHED => 'success',
                        Review::STATUS_DRAFT => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('published_at')
                    ->label('Опубліковано')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('—')
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('deleted_at')
                    ->label('У корзині з')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Review::statusOptions()),
                TrashedFilter::make()
                    ->label('Корзина'),
            ])
            ->recordActions([
                Action::make('publish')
                    ->label('Опублікувати')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Review $record): bool => ! $record->trashed() && $record->status !== Review::STATUS_PUBLISHED)
                    ->action(fn (Review $record): Review => tap($record)->publish()),
                Action::make('draft')
                    ->label('В чернетку')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->visible(fn (Review $record): bool => ! $record->trashed() && $record->status === Review::STATUS_PUBLISHED)
                    ->action(fn (Review $record): Review => tap($record)->moveToDraft()),
                EditAction::make()
                    ->visible(fn (Review $record): bool => ! $record->trashed()),
                DeleteAction::make()
                    ->visible(fn (Review $record): bool => ! $record->trashed()),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
