<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\Appointment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
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
                Select::make('service')
                    ->label('Послуга')
                    ->options(
                        collect(config('booking.services'))
                            ->mapWithKeys(fn (array $service, string $key): array => [$key => $service['label']])
                            ->all()
                    )
                    ->required(),
                Select::make('additional_service')
                    ->label('Додаткова послуга')
                    ->options(
                        collect(config('booking.services'))
                            ->mapWithKeys(fn (array $service, string $key): array => [$key => $service['label']])
                            ->all()
                    ),
                Select::make('additional_services')
                    ->label('Додаткові послуги')
                    ->multiple()
                    ->options(
                        collect(config('booking.services'))
                            ->mapWithKeys(fn (array $service, string $key): array => [$key => $service['label']])
                            ->all()
                    ),
                DatePicker::make('appointment_date')
                    ->label('Дата')
                    ->native(false)
                    ->required(),
                TimePicker::make('appointment_time')
                    ->label('Час')
                    ->seconds(false)
                    ->required(),
                TextInput::make('client_name')
                    ->label("Ім'я клієнта")
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->required()
                    ->maxLength(255),
                TextInput::make('social_contact')
                    ->label('Instagram / Telegram')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Статус')
                    ->options(Appointment::statusOptions())
                    ->default(Appointment::STATUS_PENDING)
                    ->required(),
                Select::make('source')
                    ->label('Джерело')
                    ->options([
                        'website' => 'Сайт',
                        'admin' => 'Адмінка',
                    ])
                    ->default('admin')
                    ->required(),
                Textarea::make('message')
                    ->label('Коментар')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
