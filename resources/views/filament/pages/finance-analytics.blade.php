<x-filament-panels::page>
    <style>
        .finance-analytics { display: grid; gap: 18px; }
        .finance-panel { border: 1px solid #ead8cf; border-radius: 16px; background: #fffaf7; padding: 20px; }
        .finance-pin { max-width: 460px; margin: 0 auto; text-align: center; }
        .finance-pin-icon { display: inline-grid; width: 54px; height: 54px; place-items: center; border-radius: 999px; background: #2f95ad; color: #fff; font-size: 24px; font-weight: 900; }
        .finance-title { margin: 12px 0 6px; color: #2b2421; font-size: 24px; font-weight: 900; }
        .finance-muted { color: #6b5148; font-size: 14px; line-height: 1.45; }
        .finance-pin-form { display: grid; gap: 10px; margin-top: 18px; }
        .finance-input { width: 100%; border: 1px solid #e5cfc4; border-radius: 12px; background: #fff; padding: 11px 13px; font-weight: 700; }
        .finance-input:focus { border-color: #2f95ad; outline: 3px solid rgba(47, 149, 173, 0.15); }
        .finance-button { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid #2f95ad; border-radius: 999px; background: #2f95ad; color: #fff; padding: 11px 16px; font-weight: 900; transition: 0.16s ease; }
        .finance-button:hover { filter: brightness(0.96); }
        .finance-button.is-muted { border-color: #e5cfc4; background: #fff; color: #6b5148; }
        .finance-toolbar { display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: end; }
        .finance-toolbar-title { display: grid; gap: 4px; }
        .finance-filters { display: flex; flex-wrap: wrap; gap: 10px; align-items: end; justify-content: flex-end; }
        .finance-field { display: grid; gap: 5px; min-width: 150px; }
        .finance-label { color: #6b5148; font-size: 12px; font-weight: 800; }
        .finance-quick { display: flex; flex-wrap: wrap; gap: 8px; }
        .finance-stats { display: grid; grid-template-columns: repeat(4, minmax(150px, 1fr)); gap: 12px; }
        .finance-card { border: 1px solid #ead8cf; border-radius: 14px; background: #fff; padding: 15px; min-height: 112px; }
        .finance-card.is-blue { border-color: rgba(47, 149, 173, 0.35); background: #eefaff; }
        .finance-card.is-green { border-color: rgba(44, 143, 93, 0.28); background: #f1fff6; }
        .finance-card.is-red { border-color: rgba(211, 66, 47, 0.28); background: #fff4f2; }
        .finance-card.is-gold { border-color: rgba(188, 132, 47, 0.32); background: #fff9ec; }
        .finance-card-label { color: #6b5148; font-size: 12px; font-weight: 800; line-height: 1.25; }
        .finance-card-value { margin-top: 9px; color: #201916; font-size: 28px; font-weight: 950; line-height: 1; overflow-wrap: anywhere; }
        .finance-card-note { margin-top: 8px; color: #7b6258; font-size: 12px; line-height: 1.35; }
        .finance-section-title { margin: 0 0 14px; color: #2b2421; font-size: 19px; font-weight: 900; }
        .finance-chart-wrap { overflow-x: auto; padding-bottom: 4px; }
        .finance-chart { display: flex; min-width: max-content; gap: 9px; align-items: end; min-height: 190px; border-bottom: 1px solid #ead8cf; padding: 10px 4px 0; }
        .finance-chart-day { width: 42px; display: grid; gap: 6px; align-items: end; justify-items: center; }
        .finance-bars { height: 138px; display: flex; gap: 4px; align-items: end; }
        .finance-bar { width: 16px; border-radius: 8px 8px 0 0; min-height: 0; }
        .finance-bar.is-revenue { background: #2f95ad; }
        .finance-bar.is-lost { background: #d3422f; opacity: 0.78; }
        .finance-chart-label { color: #6b5148; font-size: 11px; font-weight: 800; }
        .finance-legend { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 14px; color: #6b5148; font-size: 13px; font-weight: 700; }
        .finance-legend span { display: inline-flex; align-items: center; gap: 6px; }
        .finance-dot { width: 10px; height: 10px; border-radius: 999px; background: #2f95ad; }
        .finance-dot.is-lost { background: #d3422f; }
        @media (max-width: 900px) {
            .finance-toolbar { grid-template-columns: 1fr; }
            .finance-filters { justify-content: stretch; }
            .finance-field { flex: 1 1 140px; }
            .finance-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (max-width: 560px) {
            .finance-analytics { gap: 14px; }
            .finance-panel { border-radius: 14px; padding: 14px; }
            .finance-title { font-size: 21px; }
            .finance-filters, .finance-quick { display: grid; grid-template-columns: 1fr; width: 100%; }
            .finance-field, .finance-button { width: 100%; }
            .finance-stats { grid-template-columns: 1fr; gap: 10px; }
            .finance-card { min-height: 0; padding: 14px; }
            .finance-card-value { font-size: 25px; }
            .finance-chart-day { width: 38px; }
            .finance-bar { width: 14px; }
        }
    </style>

    <div class="finance-analytics">
        @if (! $this->isUnlocked)
            <section class="finance-panel finance-pin">
                <div class="finance-pin-icon">₴</div>
                <h2 class="finance-title">Вхід в аналітику</h2>
                <p class="finance-muted">Ця вкладка закрита додатковим PIN кодом, бо тут фінанси та статистика салону.</p>

                <form class="finance-pin-form" wire:submit="unlock">
                    <input
                        class="finance-input"
                        type="password"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="4"
                        placeholder="PIN код"
                        wire:model="pin"
                    >
                    <button type="submit" class="finance-button">Відкрити аналітику</button>
                </form>
            </section>
        @else
            @php($summary = $this->summary())

            <section class="finance-panel">
                <div class="finance-toolbar">
                    <div class="finance-toolbar-title">
                        <h2 class="finance-title">Фінансова аналітика</h2>
                        <span class="finance-muted">Період: {{ $this->periodLabel() }}</span>
                    </div>

                    <div class="finance-filters">
                        <label class="finance-field">
                            <span class="finance-label">Від</span>
                            <input class="finance-input" type="date" wire:model.live="dateFrom">
                        </label>
                        <label class="finance-field">
                            <span class="finance-label">До</span>
                            <input class="finance-input" type="date" wire:model.live="dateTo">
                        </label>
                        <div class="finance-quick">
                            <button type="button" class="finance-button is-muted" wire:click="setCurrentMonth">Цей місяць</button>
                            <button type="button" class="finance-button is-muted" wire:click="setPreviousMonth">Минулий</button>
                            <button type="button" class="finance-button is-muted" wire:click="setCurrentYear">Рік</button>
                            <button type="button" class="finance-button is-muted" wire:click="lock">Закрити</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="finance-stats">
                <article class="finance-card is-blue">
                    <div class="finance-card-label">Всього записів клієнтів</div>
                    <div class="finance-card-value">{{ $summary['appointments_total'] }}</div>
                    <div class="finance-card-note">Унікальних телефонів: {{ $summary['unique_clients'] }}</div>
                </article>
                <article class="finance-card is-green">
                    <div class="finance-card-label">Прийнято / завершено</div>
                    <div class="finance-card-value">{{ $summary['completed'] }}</div>
                    <div class="finance-card-note">Відпрацьовано: {{ $summary['worked_hours'] }} год</div>
                </article>
                <article class="finance-card is-red">
                    <div class="finance-card-label">Відмінено</div>
                    <div class="finance-card-value">{{ $summary['cancelled'] }}</div>
                    <div class="finance-card-note">Втрачено: {{ $this->money($summary['cancelled_revenue']) }}</div>
                </article>
                <article class="finance-card is-gold">
                    <div class="finance-card-label">Зворотній дзвінок</div>
                    <div class="finance-card-value">{{ $summary['callback_requests'] }}</div>
                    <div class="finance-card-note">Запити з форми консультації</div>
                </article>
                <article class="finance-card">
                    <div class="finance-card-label">Нові записи</div>
                    <div class="finance-card-value">{{ $summary['pending'] }}</div>
                    <div class="finance-card-note">Ще не змінений статус</div>
                </article>
                <article class="finance-card">
                    <div class="finance-card-label">Підтверджено</div>
                    <div class="finance-card-value">{{ $summary['confirmed'] }}</div>
                    <div class="finance-card-note">Очікують прийому</div>
                </article>
                <article class="finance-card">
                    <div class="finance-card-label">Вихідних днів виставлено</div>
                    <div class="finance-card-value">{{ $summary['full_day_blocks'] }}</div>
                    <div class="finance-card-note">Повні блокування в календарі</div>
                </article>
                <article class="finance-card is-blue">
                    <div class="finance-card-label">Відпрацьовано годин</div>
                    <div class="finance-card-value">{{ $summary['worked_hours'] }}</div>
                    <div class="finance-card-note">{{ $summary['worked_minutes'] }} хвилин у завершених записах</div>
                </article>
            </section>

            <section class="finance-stats">
                <article class="finance-card is-green">
                    <div class="finance-card-label">Фінанси отримані</div>
                    <div class="finance-card-value">{{ $this->money($summary['completed_revenue']) }}</div>
                    <div class="finance-card-note">Сума завершених прийомів</div>
                </article>
                <article class="finance-card is-red">
                    <div class="finance-card-label">Фінанси втрачені</div>
                    <div class="finance-card-value">{{ $this->money($summary['cancelled_revenue']) }}</div>
                    <div class="finance-card-note">Сума скасованих записів</div>
                </article>
                <article class="finance-card is-gold">
                    <div class="finance-card-label">Очікувані фінанси</div>
                    <div class="finance-card-value">{{ $this->money($summary['planned_revenue']) }}</div>
                    <div class="finance-card-note">Нові та підтверджені записи</div>
                </article>
                <article class="finance-card">
                    <div class="finance-card-label">Потенціал періоду</div>
                    <div class="finance-card-value">{{ $this->money($summary['all_potential_revenue']) }}</div>
                    <div class="finance-card-note">Отримані + очікувані + втрачені</div>
                </article>
            </section>

            <section class="finance-panel">
                <h3 class="finance-section-title">Графік по днях</h3>
                <div class="finance-chart-wrap">
                    <div class="finance-chart">
                        @foreach ($summary['chart'] as $day)
                            <div class="finance-chart-day" title="{{ $day['label'] }}: отримано {{ $this->money($day['revenue']) }}, втрачено {{ $this->money($day['lost']) }}">
                                <div class="finance-bars">
                                    <div class="finance-bar is-revenue" style="height: {{ $day['revenue_height'] }}px"></div>
                                    <div class="finance-bar is-lost" style="height: {{ $day['lost_height'] }}px"></div>
                                </div>
                                <span class="finance-chart-label">{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="finance-legend">
                    <span><i class="finance-dot"></i> Отримані фінанси</span>
                    <span><i class="finance-dot is-lost"></i> Втрачені фінанси</span>
                </div>
            </section>
        @endif
    </div>
</x-filament-panels::page>
