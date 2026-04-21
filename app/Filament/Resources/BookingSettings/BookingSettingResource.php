<?php

namespace App\Filament\Resources\BookingSettings;

use App\Filament\Resources\BookingSettings\Pages\CreateBookingSetting;
use App\Filament\Resources\BookingSettings\Pages\EditBookingSetting;
use App\Filament\Resources\BookingSettings\Pages\ListBookingSettings;
use App\Filament\Resources\BookingSettings\Schemas\BookingSettingForm;
use App\Filament\Resources\BookingSettings\Tables\BookingSettingsTable;
use App\Models\BookingSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BookingSettingResource extends Resource
{
    protected static ?string $model = BookingSetting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Налаштування запису';

    protected static ?string $modelLabel = 'налаштування запису';

    protected static ?string $pluralModelLabel = 'налаштування запису';

    protected static string|UnitEnum|null $navigationGroup = 'Запис';

    public static function canCreate(): bool
    {
        return ! BookingSetting::query()->exists();
    }

    public static function form(Schema $schema): Schema
    {
        return BookingSettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingSettings::route('/'),
            'create' => CreateBookingSetting::route('/create'),
            'edit' => EditBookingSetting::route('/{record}/edit'),
        ];
    }
}
