<?php

namespace App\Filament\Resources\ClientRequests;

use App\Filament\Resources\ClientRequests\Pages\CreateClientRequest;
use App\Filament\Resources\ClientRequests\Pages\EditClientRequest;
use App\Filament\Resources\ClientRequests\Pages\ListClientRequests;
use App\Filament\Resources\ClientRequests\Schemas\ClientRequestForm;
use App\Filament\Resources\ClientRequests\Tables\ClientRequestsTable;
use App\Models\ClientRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClientRequestResource extends Resource
{
    protected static ?string $model = ClientRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'client_name';

    protected static ?string $navigationLabel = "Зворотній зв'язок";

    protected static ?string $modelLabel = "зворотній зв'язок";

    protected static ?string $pluralModelLabel = "зворотній зв'язок";

    protected static ?int $navigationSort = 30;

    public static function getNavigationBadge(): ?string
    {
        $count = ClientRequest::query()
            ->where('status', ClientRequest::STATUS_NEW)
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return ClientRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientRequestsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClientRequests::route('/'),
            'create' => CreateClientRequest::route('/create'),
            'edit' => EditClientRequest::route('/{record}/edit'),
        ];
    }
}
