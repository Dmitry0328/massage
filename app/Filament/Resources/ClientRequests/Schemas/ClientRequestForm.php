<?php

namespace App\Filament\Resources\ClientRequests\Schemas;

use App\Models\ClientRequest;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ClientRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('master_id')
                    ->label('Майстер')
                    ->relationship(
                        'master',
                        'name',
                        modifyQueryUsing: fn (Builder $query): Builder => $query->orderBy('sort_order')->orderBy('name'),
                    )
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('client_name')
                    ->label("Ім'я клієнта")
                    ->required()
                    ->maxLength(80),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Textarea::make('message')
                    ->label('Повідомлення')
                    ->rows(4)
                    ->columnSpanFull(),
                Select::make('status')
                    ->label('Статус')
                    ->options(ClientRequest::statusOptions())
                    ->default(ClientRequest::STATUS_NEW)
                    ->required(),
            ]);
    }
}
