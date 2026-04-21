<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Models\Appointment;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client_name')
                    ->label("Клієнт")
                    ->searchable()
                    ->sortable(),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service')
                    ->label('Послуга')
                    ->formatStateUsing(fn (string $state): string => config("booking.services.{$state}.label", $state))
                    ->wrap(),
                TextColumn::make('additional_service')
                    ->label('Додатково')
                    ->formatStateUsing(fn (?string $state): string => $state ? config("booking.services.{$state}.label", $state) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('additional_services')
                    ->label('Додаткові послуги')
                    ->formatStateUsing(function (?array $state): string {
                        if (! filled($state)) {
                            return '—';
                        }

                        return collect($state)
                            ->map(fn (string $service): string => config("booking.services.{$service}.label", $service))
                            ->join(', ');
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('appointment_date')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('appointment_time')
                    ->label('Час')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => Appointment::statusOptions()[$state] ?? $state)
                    ->color(fn (string $state): string => match ($state) {
                        Appointment::STATUS_PENDING => 'warning',
                        Appointment::STATUS_CONFIRMED => 'success',
                        Appointment::STATUS_COMPLETED => 'info',
                        Appointment::STATUS_CANCELLED => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('master_id')
                    ->label('Майстер')
                    ->relationship('master', 'name'),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Appointment::statusOptions()),
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
            ->defaultSort('appointment_date')
            ->defaultSort('appointment_time');
    }
}
