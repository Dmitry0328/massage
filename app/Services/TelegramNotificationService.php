<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\ClientRequest;
use App\Models\MassageService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramNotificationService
{
    public function appointmentCreated(Appointment $appointment): void
    {
        $appointment->loadMissing('master');

        $services = collect([
            $appointment->service,
            ...($appointment->additional_services ?? []),
        ])
            ->filter()
            ->unique()
            ->map(fn (string $service): string => $this->escape(MassageService::labelFor($service)))
            ->implode("\n- ");

        $this->send([
            '✨ <b>Новий запис на масаж</b>',
            '',
            "👤 <b>Клієнт</b>\n"
                . 'Ім’я: ' . $this->escape($appointment->client_name) . "\n"
                . 'Телефон: ' . $this->escape($appointment->phone)
                . ($appointment->social_contact ? "\nСоцмережі: " . $this->escape($appointment->social_contact) : ''),
            '',
            "📅 <b>Запис</b>\n"
                . 'Майстер: ' . $this->escape($appointment->master?->name ?? 'не вказано') . "\n"
                . 'Дата: ' . $this->escape($appointment->appointment_date?->format('d.m.Y') ?? 'не вказано') . "\n"
                . 'Час: ' . $this->escape($appointment->appointment_time ?? 'не вказано'),
            '',
            "💆 <b>Послуги</b>"
                . ($services ? "\n- {$services}" : "\nне вказано"),
            $appointment->message ? "\n📝 <b>Коментар</b>\n" . $this->escape($appointment->message) : null,
        ]);
    }

    public function clientRequestCreated(ClientRequest $clientRequest): void
    {
        $clientRequest->loadMissing('master');

        $this->send([
            '📞 <b>Новий запит на зворотній дзвінок</b>',
            '',
            'Клієнт: ' . $this->escape($clientRequest->client_name),
            'Телефон: ' . $this->escape($clientRequest->phone),
            'Майстер: ' . $this->escape($clientRequest->master?->name ?? 'не вказано'),
            $clientRequest->message ? $this->escape($clientRequest->message) : null,
        ]);
    }

    /**
     * @param array<int, string|null> $lines
     */
    private function send(array $lines): void
    {
        if (! config('services.telegram.enabled')) {
            Log::info('Telegram notification skipped: disabled');

            return;
        }

        $token = (string) config('services.telegram.bot_token');
        $chatId = (string) config('services.telegram.chat_id');

        if ($token === '' || $chatId === '') {
            Log::warning('Telegram notification skipped: missing bot token or chat id', [
                'has_token' => $token !== '',
                'has_chat_id' => $chatId !== '',
            ]);

            return;
        }

        $text = collect($lines)
            ->filter(fn (?string $line): bool => filled($line))
            ->implode("\n");

        try {
            Http::timeout(8)
                ->retry(2, 300)
                ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ])
                ->throw();
        } catch (Throwable $exception) {
            Log::warning('Telegram notification failed', [
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function escape(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
