<?php

namespace App\Filament\Resources\ScheduleBlocks;

use App\Filament\Resources\ScheduleBlocks\Pages\CreateScheduleBlock;
use App\Filament\Resources\ScheduleBlocks\Pages\EditScheduleBlock;
use App\Filament\Resources\ScheduleBlocks\Pages\ListScheduleBlocks;
use App\Filament\Resources\ScheduleBlocks\Schemas\ScheduleBlockForm;
use App\Filament\Resources\ScheduleBlocks\Tables\ScheduleBlocksTable;
use App\Models\ScheduleBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ScheduleBlockResource extends Resource
{
    protected static ?string $model = ScheduleBlock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Блокування';

    protected static ?string $modelLabel = 'блокування';

    protected static ?string $pluralModelLabel = 'блокування';

    protected static string|UnitEnum|null $navigationGroup = 'Запис';

    public static function form(Schema $schema): Schema
    {
        return ScheduleBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ScheduleBlocksTable::configure($table);
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
            'index' => ListScheduleBlocks::route('/'),
            'create' => CreateScheduleBlock::route('/create'),
            'edit' => EditScheduleBlock::route('/{record}/edit'),
        ];
    }
}
