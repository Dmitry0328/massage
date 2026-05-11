<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Models\Appointment;
use App\Models\MassageService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                    ->label('Клієнт')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('master.name')
                    ->label('Майстер')
                    ->searchable()
                    ->sortable()
                    ->visibleFrom('md'),
                TextColumn::make('service')
                    ->label('Основна послуга')
                    ->formatStateUsing(fn (string $state): string => MassageService::labelFor($state))
                    ->wrap(),
                TextColumn::make('additional_services')
                    ->label('Додаткові послуги')
                    ->formatStateUsing(function (mixed $state, Appointment $record): string {
                        $services = array_values(array_unique(array_filter([
                            $record->additional_service,
                            ...self::normalizeAdditionalServices($state),
                        ])));

                        if (! filled($services)) {
                            return '—';
                        }

                        return collect($services)
                            ->map(fn (string $service): string => MassageService::labelFor($service))
                            ->join(', ');
                    })
                    ->wrap()
                    ->toggleable()
                    ->visibleFrom('lg'),
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
                    ->copyable()
                    ->visibleFrom('md'),
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
                    })
                    ->visibleFrom('md'),
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('appointment_date');
    }

    /**
     * @return array<int, string>
     */
    private static function normalizeAdditionalServices(mixed $state): array
    {
        if (blank($state)) {
            return [];
        }

        if (is_array($state)) {
            return array_filter($state, is_string(...));
        }

        if (is_string($state)) {
            $decoded = json_decode($state, true);

            if (is_array($decoded)) {
                return array_filter($decoded, is_string(...));
            }

            return [$state];
        }

        return [];
    }
}
