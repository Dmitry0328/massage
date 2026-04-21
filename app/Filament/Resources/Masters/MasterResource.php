<?php

namespace App\Filament\Resources\Masters;

use App\Filament\Resources\Masters\Pages\CreateMaster;
use App\Filament\Resources\Masters\Pages\EditMaster;
use App\Filament\Resources\Masters\Pages\ListMasters;
use App\Filament\Resources\Masters\Schemas\MasterForm;
use App\Filament\Resources\Masters\Tables\MastersTable;
use App\Models\Master;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MasterResource extends Resource
{
    protected static ?string $model = Master::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Майстри';

    protected static ?string $modelLabel = 'майстер';

    protected static ?string $pluralModelLabel = 'майстри';

    protected static string|UnitEnum|null $navigationGroup = 'Запис';

    public static function form(Schema $schema): Schema
    {
        return MasterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MastersTable::configure($table);
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
            'index' => ListMasters::route('/'),
            'create' => CreateMaster::route('/create'),
            'edit' => EditMaster::route('/{record}/edit'),
        ];
    }
}
