<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\ClientRequest;
use App\Models\MassageService;
use App\Models\Review;
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
            ->map(fn (string $service): string => MassageService::labelFor($service))
            ->implode("\n- ");

        $this->send([
            'Новий запис на масаж',
            '',
            "Клієнт: {$appointment->client_name}",
            "Телефон: {$appointment->phone}",
            $appointment->social_contact ? "Telegram / Instagram / Viber: {$appointment->social_contact}" : null,
            'Майстер: ' . ($appointment->master?->name ?? 'не вказано'),
            'Послуги: ' . ($services ? "\n- {$services}" : 'не вказано'),
            "Дата: {$appointment->appointment_date?->format('d.m.Y')}",
            "Час: {$appointment->appointment_time}",
            $appointment->message ? "Коментар:\n{$appointment->message}" : null,
        ]);
    }

    public function clientRequestCreated(ClientRequest $clientRequest): void
    {
        $clientRequest->loadMissing('master');

        $this->send([
            'Новий запит на зворотний дзвінок',
            '',
            "Клієнт: {$clientRequest->client_name}",
            "Телефон: {$clientRequest->phone}",
            'Майстер: ' . ($clientRequest->master?->name ?? 'не вказано'),
            $clientRequest->message,
        ]);
    }

    public function reviewCreated(Review $review): void
    {
        $review->loadMissing('master');

        $this->send([
            'Новий відгук на модерацію',
            '',
            "Клієнт: {$review->client_name}",
            'Майстер: ' . ($review->master?->name ?? 'не вказано'),
            "Оцінка: {$review->rating}",
            "Текст:\n{$review->text}",
        ]);
    }

    /**
     * @param array<int, string|null> $lines
     */
    private function send(array $lines): void
    {
        if (! config('services.telegram.enabled')) {
            return;
        }

        $token = (string) config('services.telegram.bot_token');
        $chatId = (string) config('services.telegram.chat_id');

        if ($token === '' || $chatId === '') {
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
                    'disable_web_page_preview' => true,
                ])
                ->throw();
        } catch (Throwable $exception) {
            Log::warning('Telegram notification failed', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
