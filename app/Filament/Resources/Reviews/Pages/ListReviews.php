<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use App\Models\Review;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Всі'),
            'draft' => Tab::make('На модерації')
                ->query(fn (Builder $query): Builder => $query->where('status', Review::STATUS_DRAFT)),
            'published' => Tab::make('Опубліковані')
                ->query(fn (Builder $query): Builder => $query->where('status', Review::STATUS_PUBLISHED)),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
