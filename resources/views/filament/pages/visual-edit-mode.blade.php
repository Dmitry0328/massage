<x-filament-panels::page>
    <style>
        .visual-edit-page { display: grid; gap: 16px; max-width: 760px; color: #241d1a; color-scheme: light; }
        .visual-edit-card { border: 1px solid #ead8cf; border-radius: 16px; background: #fffaf7; color: #241d1a; padding: 20px; }
        .visual-edit-title { margin: 0 0 8px; font-size: 24px; font-weight: 900; }
        .visual-edit-text { margin: 0; color: #6b5148; line-height: 1.5; }
        .visual-edit-pin { max-width: 460px; text-align: center; }
        .visual-edit-pin-icon { display: inline-grid; width: 54px; height: 54px; place-items: center; border-radius: 999px; background: #2f95ad; color: #fff; font-size: 24px; font-weight: 900; }
        .visual-edit-pin-form { display: grid; gap: 10px; margin-top: 18px; }
        .visual-edit-input { width: 100%; min-width: 0; border: 1px solid #d8c0b4; border-radius: 12px; background: #fff; color: #241d1a; -webkit-text-fill-color: #241d1a; color-scheme: light; padding: 11px 13px; font-weight: 700; }
        .visual-edit-input::placeholder { color: #8d746b; -webkit-text-fill-color: #8d746b; }
        .visual-edit-input:focus { border-color: #2f95ad; outline: 3px solid rgba(47, 149, 173, 0.15); }
        .visual-edit-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .visual-edit-button { display: inline-flex; align-items: center; justify-content: center; border: 1px solid #2f95ad; border-radius: 999px; background: #2f95ad; color: #fff; padding: 11px 16px; font-weight: 900; text-decoration: none; }
        .visual-edit-button.is-muted { border-color: #d8c0b4; background: #fff; color: #5d463f; }
        @media (max-width: 560px) {
            .visual-edit-card { border-radius: 14px; padding: 14px; }
            .visual-edit-button { width: 100%; }
        }
    </style>

    <div class="visual-edit-page">
        @if (! $this->isUnlocked)
            <section class="visual-edit-card visual-edit-pin">
                <div class="visual-edit-pin-icon">✎</div>
                <h2 class="visual-edit-title">Вхід в Edit mode</h2>
                <p class="visual-edit-text">Ця вкладка закрита PIN кодом, бо тут можна змінювати текст і фото на сайті.</p>

                <form class="visual-edit-pin-form" wire:submit="unlock">
                    <input
                        class="visual-edit-input"
                        type="password"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        placeholder="PIN код"
                        wire:model="pin"
                    >

                    <button type="submit" class="visual-edit-button">
                        Відкрити
                    </button>
                </form>
            </section>
        @else
            <section class="visual-edit-card">
                <h2 class="visual-edit-title">Візуальне редагування сайту</h2>
                <p class="visual-edit-text">
                    Натисни кнопку нижче, сайт відкриється в Edit mode. У цьому режимі можна клікати по тексту або фото,
                    редагувати їх і зберігати зміни. Сама адмінка не редагується.
                </p>
                <div class="visual-edit-actions">
                    <a class="visual-edit-button" href="{{ $this->editUrl() }}" target="_blank" rel="noopener">
                        Відкрити сайт в Edit mode
                    </a>
                    <a class="visual-edit-button is-muted" href="{{ $this->publicUrl() }}" target="_blank" rel="noopener">
                        Відкрити сайт без редагування
                    </a>
                    <button type="button" class="visual-edit-button is-muted" wire:click="lock">
                        Закрити
                    </button>
                </div>
            </section>
        @endif
    </div>
</x-filament-panels::page>
