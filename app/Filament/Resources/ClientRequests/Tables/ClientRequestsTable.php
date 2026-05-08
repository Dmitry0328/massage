<?php

namespace App\Filament\Resources\ClientRequests\Tables;

use App\Models\ClientRequest;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClientRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->label("Ім'я")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->copyable()
                    ->searchable(),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('message')
                    ->label('Запит')
                    ->limit(120)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ClientRequest::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        ClientRequest::STATUS_NEW => 'warning',
                        ClientRequest::STATUS_CONTACTED => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(ClientRequest::statusOptions()),
            ])
            ->recordActions([
                Action::make('markContacted')
                    ->label('Передзвонили')
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->visible(fn (ClientRequest $record): bool => $record->status !== ClientRequest::STATUS_CONTACTED)
                    ->action(fn (ClientRequest $record): bool => $record->update(['status' => ClientRequest::STATUS_CONTACTED])),
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
