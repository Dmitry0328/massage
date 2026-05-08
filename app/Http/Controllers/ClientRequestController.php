<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use App\Models\Master;
use App\Services\TelegramNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientRequestController extends Controller
{
    public function __construct(
        private readonly TelegramNotificationService $telegramNotificationService,
    ) {
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'phone' => $this->normalizePhone((string) $request->input('phone')),
        ]);

        $validator = Validator::make($request->all(), [
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'client_name' => ['required', 'string', 'min:2', 'max:80'],
            'phone' => ['required', 'regex:/^\+380\d{9}$/'],
        ], [
            'master_id.required' => 'Оберіть майстра для консультації.',
            'master_id.exists' => 'Оберіть активного майстра.',
            'client_name.required' => "Вкажіть ім'я.",
            'client_name.min' => "Ім'я має містити щонайменше 2 символи.",
            'phone.required' => 'Вкажіть номер телефону.',
            'phone.regex' => 'Вкажіть номер у форматі +380XXXXXXXXX.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('booking.index')
                ->withErrors($validator, 'clientRequest')
                ->withInput()
                ->with('open_client_request_popup', true);
        }

        $data = $validator->validated();
        $master = Master::query()->findOrFail($data['master_id']);

        $clientRequest = ClientRequest::query()->create([
            'master_id' => $master->id,
            'client_name' => $data['client_name'],
            'phone' => $data['phone'],
            'message' => sprintf(
                "Клієнт %s хоче поспілкуватись з майстром %s. Потрібно зателефонувати.",
                $data['client_name'],
                $master->name,
            ),
            'status' => ClientRequest::STATUS_NEW,
        ]);

        $this->telegramNotificationService->clientRequestCreated($clientRequest);

        return redirect()
            ->route('booking.index')
            ->with('client_request_success', 'Дякуємо! Ми отримали запит і зателефонуємо вам найближчим часом.');
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/[\s\-()]/', '', $phone) ?? $phone;
    }
}
