<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class VisualEditMode extends Page
{
    protected string $view = 'filament.pages.visual-edit-mode';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $navigationLabel = 'Edit mode';

    protected static ?string $title = 'Edit mode';

    protected static ?int $navigationSort = 16;

    public function editUrl(): string
    {
        return url('/?edit_mode=1');
    }

    public function publicUrl(): string
    {
        return url('/');
    }
}
