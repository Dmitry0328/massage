<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->has('client_name')) {
            $request->merge([
                'client_name' => trim(preg_replace('/\s+/', ' ', (string) $request->input('client_name'))),
            ]);
        }

        $validated = $request->validateWithBag('review', [
            'client_name' => ['required', 'string', 'min:2', 'max:80'],
            'master_id' => ['required', 'integer', Rule::exists('masters', 'id')->where('is_active', true)],
            'text' => ['required', 'string', 'min:10', 'max:2000'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5', 'multiple_of:0.5'],
        ], [
            'client_name.required' => "Вкажіть ім'я.",
            'client_name.min' => "Ім'я має містити щонайменше 2 символи.",
            'master_id.required' => 'Оберіть майстра.',
            'text.required' => 'Напишіть текст відгуку.',
            'text.min' => 'Відгук має містити щонайменше 10 символів.',
            'rating.required' => 'Оберіть оцінку.',
            'rating.multiple_of' => 'Оцінку можна ставити з кроком 0.5.',
        ]);

        Review::purgeExpiredTrash();

        Review::query()->create([
            'client_name' => $validated['client_name'],
            'master_id' => $validated['master_id'],
            'text' => $validated['text'],
            'rating' => (float) $validated['rating'],
            'status' => Review::STATUS_DRAFT,
        ]);

        return redirect()
            ->to(route('booking.index') . '#reviews')
            ->with('review_success', 'Дякую за відгук! Відгук переданий на модерацію. Найближчим часом він зʼявиться на сайті.');
    }
}
