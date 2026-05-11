<x-filament-panels::page>
    <style>
        .master-calendar { display: grid; gap: 18px; max-width: 100%; color: #241d1a; color-scheme: light; }
        .master-calendar *, .master-calendar *::before, .master-calendar *::after { box-sizing: border-box; }
        .calendar-panel { max-width: 100%; overflow: hidden; border: 1px solid #ead8cf; border-radius: 16px; background: #fffaf7; color: #241d1a; padding: 20px; }
        .calendar-toolbar { display: grid; grid-template-columns: 1fr auto; gap: 14px; align-items: center; }
        .calendar-toolbar strong { color: #241d1a; line-height: 1.35; overflow-wrap: anywhere; }
        .calendar-month-controls { display: flex; align-items: center; justify-content: center; gap: 14px; }
        .calendar-nav, .calendar-save, .calendar-action { display: inline-flex; align-items: center; justify-content: center; min-width: 0; border: 1px solid #d8c0b4; border-radius: 999px; background: #fff; color: #241d1a; padding: 9px 14px; font-weight: 700; }
        .calendar-title { min-width: 180px; color: #241d1a; text-align: center; font-size: 18px; font-weight: 800; overflow-wrap: anywhere; }
        .calendar-days { display: grid; grid-template-columns: repeat(auto-fill, minmax(74px, 1fr)); gap: 10px; margin-top: 18px; }
        .calendar-day { display: grid; align-content: center; justify-items: center; min-width: 0; min-height: 92px; border: 1px solid #ead8cf; border-radius: 16px; background: #fff; color: #241d1a; padding: 10px 8px; text-align: center; transition: 0.16s ease; }
        .calendar-day:hover { border-color: #2f95ad; }
        .calendar-day.is-selected { border-color: #d3422f; background: #fff3f1; box-shadow: inset 0 0 0 2px #d3422f; }
        .calendar-day.is-disabled { opacity: 0.44; }
        .calendar-day.is-disabled.is-today { opacity: 1; }
        .calendar-weekday { color: #6b5148; font-size: 12px; font-weight: 700; text-transform: lowercase; }
        .calendar-date-number { display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 42px; border-radius: 999px; font-size: 28px; font-weight: 800; line-height: 1; margin-top: 6px; }
        .calendar-day.is-today .calendar-date-number { background: #9ed8ef; color: #10212a; }
        .calendar-day.is-selected .calendar-date-number { background: transparent; color: inherit; }
        .calendar-day.is-selected.is-today .calendar-date-number { background: #9ed8ef; color: #10212a; }
        .calendar-month { display: block; margin-top: 4px; color: #6b5148; font-size: 12px; font-weight: 700; }
        .calendar-selected-label { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; margin-top: 16px; border: 1px solid #f0c0b8; border-radius: 14px; background: #fff3f1; color: #8f2d21; font-weight: 800; padding: 10px 12px; }
        .calendar-actions { display: flex; flex-wrap: wrap; gap: 8px; }
        .calendar-action.is-danger { border-color: #d3422f; color: #9b2d1f; }
        .calendar-action.is-muted { color: #6b5148; }
        .calendar-slots { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-top: 18px; }
        .calendar-slot { min-width: 0; border: 1px solid #ead8cf; border-radius: 14px; background: #fff; color: #241d1a; padding: 11px 12px; text-align: center; }
        .calendar-slot.is-appointment { border-color: #f1b8ac; background: #fff0ec; color: #9b2d1f; cursor: pointer; }
        .calendar-slot.is-blocked { border-color: #d8c6b9; background: #f4eee9; color: #6b5148; }
        .calendar-slot-time { display: block; font-weight: 800; }
        .calendar-slot-meta { display: block; margin-top: 3px; font-size: 12px; }
        .calendar-slot-tools { display: flex; justify-content: center; gap: 6px; margin-top: 9px; }
        .calendar-mini-action { border: 1px solid #d8c0b4; border-radius: 999px; background: #fff; color: #241d1a; padding: 5px 9px; font-size: 12px; font-weight: 700; }
        .calendar-settings { display: grid; gap: 18px; }
        .calendar-settings-grid { display: grid; grid-template-columns: repeat(4, minmax(160px, 1fr)); gap: 14px; align-items: end; }
        .calendar-weekdays { display: flex; flex-wrap: wrap; gap: 8px; }
        .calendar-weekday-toggle { display: inline-flex; align-items: center; gap: 7px; border: 1px solid #d8c0b4; border-radius: 999px; background: #fff; color: #241d1a; padding: 8px 12px; font-weight: 700; }
        .calendar-weekday-toggle input { accent-color: #d3422f; }
        .calendar-site-toggle { display: flex; align-items: center; justify-content: space-between; gap: 14px; border: 1px solid #d8c0b4; border-radius: 14px; background: #fff; color: #241d1a; padding: 12px 14px; }
        .calendar-site-toggle strong { display: block; color: #2b2421; }
        .calendar-site-toggle span { display: block; margin-top: 2px; color: #6b5148; font-size: 13px; }
        .calendar-site-toggle input { width: 20px; height: 20px; accent-color: #d3422f; }
        .calendar-label { display: block; margin-bottom: 6px; color: #6b5148; font-size: 13px; font-weight: 600; }
        .calendar-input { width: 100%; min-width: 0; border: 1px solid #d8c0b4; border-radius: 12px; background: #fff; color: #241d1a; -webkit-text-fill-color: #241d1a; color-scheme: light; padding: 10px 12px; }
        .calendar-modal { position: fixed; inset: 0; z-index: 60; display: grid; place-items: center; padding: 20px; }
        .calendar-modal-backdrop { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.36); }
        .calendar-modal-dialog { position: relative; width: min(560px, 100%); border-radius: 16px; background: #fff; color: #241d1a; padding: 22px; box-shadow: 0 24px 80px rgba(0, 0, 0, 0.24); }
        .calendar-modal-title { margin: 0 0 14px; font-size: 22px; font-weight: 800; }
        .calendar-details { display: grid; gap: 10px; }
        .calendar-detail-row { display: grid; grid-template-columns: 160px 1fr; gap: 12px; border-bottom: 1px solid #f1e2db; padding-bottom: 8px; }
        .calendar-detail-label { color: #6b5148; font-weight: 700; }
        @media (max-width: 760px) {
            .master-calendar { gap: 14px; }
            .calendar-panel { border-radius: 14px; padding: 14px; }
            .calendar-toolbar, .calendar-settings-grid, .calendar-detail-row { grid-template-columns: 1fr; }
            .calendar-month-controls { justify-content: space-between; gap: 8px; }
            .calendar-title { min-width: 0; font-size: 17px; }
            .calendar-nav { min-width: 42px; min-height: 42px; padding: 8px 12px; }
            .calendar-days { grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 6px; }
            .calendar-day { min-height: 76px; border-radius: 12px; padding: 7px 3px; }
            .calendar-date-number { width: 34px; height: 34px; font-size: 22px; }
            .calendar-weekday, .calendar-month { font-size: 11px; }
            .calendar-selected-label { align-items: stretch; border-radius: 12px; }
            .calendar-actions, .calendar-action, .calendar-save { width: 100%; justify-content: center; text-align: center; }
            .calendar-slots { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
            .calendar-slot { border-radius: 12px; padding: 10px 8px; }
            .calendar-slot-time { font-size: 16px; }
            .calendar-slot-meta { font-size: 11px; overflow-wrap: anywhere; }
            .calendar-mini-action { width: 100%; }
            .calendar-modal { align-items: end; padding: 10px; }
            .calendar-modal-dialog { width: 100%; max-height: calc(100dvh - 20px); overflow-y: auto; border-radius: 16px 16px 10px 10px; padding: 16px; }
            .calendar-modal-title { font-size: 20px; }
            .calendar-detail-row { gap: 4px; }
            .calendar-detail-label { font-size: 12px; }
        }

        @media (max-width: 420px) {
            .calendar-panel { padding: 10px; }
            .calendar-days { gap: 5px; }
            .calendar-day { min-height: 66px; border-radius: 10px; padding: 6px 2px; }
            .calendar-date-number { width: 28px; height: 28px; font-size: 18px; margin-top: 2px; }
            .calendar-weekday, .calendar-month { font-size: 10px; line-height: 1.1; }
            .calendar-month { margin-top: 2px; }
            .calendar-slots { grid-template-columns: 1fr; }
        }
    </style>

    <div class="master-calendar">
        <section class="calendar-panel">
            <div class="calendar-toolbar">
                <strong>Календар салону: всі майстри обʼєднані в один графік</strong>
                <div class="calendar-month-controls">
                    <button type="button" class="calendar-nav" wire:click="previousMonth">‹</button>
                    <div class="calendar-title">{{ $this->monthTitle() }}</div>
                    <button type="button" class="calendar-nav" wire:click="nextMonth">›</button>
                </div>
            </div>

            <div class="calendar-days">
                @foreach ($this->calendarDays() as $day)
                    <button
                        type="button"
                        @class([
                            'calendar-day',
                            'is-selected' => $day['is_selected'],
                            'is-today' => $day['is_today'],
                            'is-disabled' => ! $day['available'],
                        ])
                        wire:click="selectDate('{{ $day['date'] }}')"
                    >
                        <span class="calendar-weekday">{{ $day['weekday'] }}</span>
                        <span class="calendar-date-number">{{ $day['day'] }}</span>
                        <span class="calendar-month">{{ $day['month'] }}</span>
                    </button>
                @endforeach
            </div>

            @if ($this->selectedDateLabel())
                <div class="calendar-selected-label">
                    <span>Обрана дата: {{ $this->selectedDateLabel() }}</span>
                    <div class="calendar-actions">
                        @if ($block = $this->fullDayBlock())
                            <button type="button" class="calendar-action is-muted" wire:click="unblock({{ $block->id }})">
                                Зняти блокування дня
                            </button>
                        @else
                            <button type="button" class="calendar-action is-danger" wire:click="blockSelectedDate">
                                Заблокувати весь день
                            </button>
                        @endif
                        <a class="calendar-action" href="{{ route('filament.admin.resources.appointments.create') }}">
                            Записати клієнта вручну
                        </a>
                    </div>
                </div>
            @endif

            <div class="calendar-slots">
                @forelse ($this->slotsForSelectedDate() as $slot)
                    @if ($slot['status'] === 'appointment')
                        <button type="button" class="calendar-slot is-appointment" wire:click="openAppointment({{ $slot['appointment_id'] }})">
                            <span class="calendar-slot-time">{{ $slot['time'] }}</span>
                            <span class="calendar-slot-meta">Зайнято: {{ $slot['client'] }}</span>
                            <span class="calendar-slot-meta">Майстер: {{ $slot['master'] }}</span>
                        </button>
                    @elseif ($slot['status'] === 'blocked')
                        <div class="calendar-slot is-blocked">
                            <span class="calendar-slot-time">{{ $slot['time'] }}</span>
                            <span class="calendar-slot-meta">Заблоковано</span>
                            <div class="calendar-slot-tools">
                                <button type="button" class="calendar-mini-action" wire:click="unblock({{ $slot['block_id'] }})">Зняти</button>
                            </div>
                        </div>
                    @else
                        <div class="calendar-slot">
                            <span class="calendar-slot-time">{{ $slot['time'] }}</span>
                            <span class="calendar-slot-meta">Вільно</span>
                            <div class="calendar-slot-tools">
                                <button type="button" class="calendar-mini-action" wire:click="blockSlot('{{ $slot['time'] }}')">Заблокувати час</button>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="calendar-slot">Немає доступних слотів.</div>
                @endforelse
            </div>
        </section>

        <section class="calendar-panel">
            <h2 style="margin: 0 0 14px; font-size: 18px; font-weight: 800;">Налаштування запису</h2>
            <div class="calendar-settings">
                <div>
                    <span class="calendar-label">Робочі дні салону</span>
                    <div class="calendar-weekdays">
                        @foreach ([1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Нд'] as $weekday => $label)
                            <label class="calendar-weekday-toggle">
                                <input type="checkbox" value="{{ $weekday }}" wire:model.live="workingDays">
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="calendar-settings-grid">
                    <div>
                        <label class="calendar-label" for="work-start-time">Початок роботи</label>
                        <input
                            id="work-start-time"
                            class="calendar-input"
                            type="time"
                            wire:model.live="workStartTime"
                        >
                    </div>

                    <div>
                        <label class="calendar-label" for="work-end-time">Кінець роботи</label>
                        <input
                            id="work-end-time"
                            class="calendar-input"
                            type="time"
                            wire:model.live="workEndTime"
                        >
                    </div>

                    <div>
                        <label class="calendar-label" for="slot-step-minutes">Інтервал часу</label>
                        <select id="slot-step-minutes" class="calendar-input" wire:model.live="slotStepMinutes">
                            <option value="15">15 хв</option>
                            <option value="30">30 хв</option>
                            <option value="45">45 хв</option>
                            <option value="60">60 хв</option>
                            <option value="90">90 хв</option>
                            <option value="120">120 хв</option>
                        </select>
                    </div>

                    <div>
                        <label class="calendar-label" for="max-advance-months">Місяців для запису</label>
                        <input
                            id="max-advance-months"
                            class="calendar-input"
                            type="number"
                            min="1"
                            max="12"
                            wire:model.live="maxAdvanceMonths"
                        >
                    </div>
                </div>

                <label class="calendar-site-toggle">
                    <span>
                        <strong>Показувати блок "Як записатись за 10 секунд"</strong>
                        <span>Увімкніть, якщо потрібно показати інструкцію запису на головній сторінці.</span>
                    </span>
                    <input type="checkbox" wire:model.live="showQuickBookBlock">
                </label>

                <button type="button" class="calendar-save" wire:click="saveSettings">
                    Зберегти графік
                </button>
            </div>
        </section>
    </div>

    @if ($appointment = $this->selectedAppointment())
        <div class="calendar-modal" role="dialog" aria-modal="true">
            <button type="button" class="calendar-modal-backdrop" wire:click="closeAppointment" aria-label="Закрити"></button>
            <div class="calendar-modal-dialog">
                <h2 class="calendar-modal-title">Деталі запису</h2>
                <div class="calendar-details">
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Клієнт</span><span>{{ $appointment->client_name }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Телефон</span><span>{{ $appointment->phone }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Майстер</span><span>{{ $appointment->master?->name ?? '—' }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Основна послуга</span><span>{{ $this->serviceLabel($appointment->service) }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Додаткові послуги</span><span>{{ $this->additionalServicesLabel($appointment) }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Дата і час</span><span>{{ $appointment->appointment_date->format('d.m.Y') }}, {{ substr((string) $appointment->appointment_time, 0, 5) }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Тривалість</span><span>{{ $this->appointmentDurationLabel($appointment) }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Instagram / Telegram</span><span>{{ $appointment->social_contact ?: '—' }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Коментар</span><span>{{ $appointment->message ?: '—' }}</span></div>
                    <div class="calendar-detail-row"><span class="calendar-detail-label">Статус</span><span>{{ \App\Models\Appointment::statusOptions()[$appointment->status] ?? $appointment->status }}</span></div>
                </div>
                <div style="display: flex; justify-content: flex-end; margin-top: 18px;">
                    <button type="button" class="calendar-save" wire:click="closeAppointment">Закрити</button>
                </div>
            </div>
        </div>
    @endif
</x-filament-panels::page>
