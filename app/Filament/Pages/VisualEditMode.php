<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class VisualEditMode extends Page
{
    protected string $view = 'filament.pages.visual-edit-mode';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static ?string $navigationLabel = 'Edit mode';

    protected static ?string $title = 'Edit mode';

    protected static ?int $navigationSort = 999;

    public string $pin = '';

    public bool $isUnlocked = false;

    public function mount(): void
    {
        $this->isUnlocked = false;
    }

    public function unlock(): void
    {
        if ($this->pin !== '1122') {
            Notification::make()
                ->title('Невірний PIN код')
                ->danger()
                ->send();

            return;
        }

        $this->isUnlocked = true;
        $this->pin = '';

        Notification::make()
            ->title('Edit mode відкрито')
            ->success()
            ->send();
    }

    public function lock(): void
    {
        $this->isUnlocked = false;
        $this->pin = '';
    }

    public function editUrl(): string
    {
        return url('/?edit_mode=1');
    }

    public function publicUrl(): string
    {
        return url('/');
    }
}
