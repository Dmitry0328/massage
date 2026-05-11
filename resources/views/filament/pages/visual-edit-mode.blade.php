<x-filament-panels::page>
    <style>
        .visual-edit-page { display: grid; gap: 16px; max-width: 760px; color: #241d1a; color-scheme: light; }
        .visual-edit-card { border: 1px solid #ead8cf; border-radius: 16px; background: #fffaf7; color: #241d1a; padding: 20px; }
        .visual-edit-title { margin: 0 0 8px; font-size: 24px; font-weight: 900; }
        .visual-edit-text { margin: 0; color: #6b5148; line-height: 1.5; }
        .visual-edit-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .visual-edit-button { display: inline-flex; align-items: center; justify-content: center; border: 1px solid #2f95ad; border-radius: 999px; background: #2f95ad; color: #fff; padding: 11px 16px; font-weight: 900; text-decoration: none; }
        .visual-edit-button.is-muted { border-color: #d8c0b4; background: #fff; color: #5d463f; }
        @media (max-width: 560px) {
            .visual-edit-card { border-radius: 14px; padding: 14px; }
            .visual-edit-button { width: 100%; }
        }
    </style>

    <div class="visual-edit-page">
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
            </div>
        </section>
    </div>
</x-filament-panels::page>
