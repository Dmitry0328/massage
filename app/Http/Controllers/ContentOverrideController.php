<?php

namespace App\Http\Controllers;

use App\Models\ContentOverride;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ContentOverrideController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'page_key' => ['nullable', 'string', 'max:80'],
            'selector' => ['required', 'string', 'max:1000'],
            'type' => ['required', Rule::in(['text', 'image'])],
            'original_hash' => ['nullable', 'string', 'max:80'],
            'value' => ['nullable', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'max:8192'],
        ]);

        $value = $data['value'] ?? '';
        $meta = [];

        if (($data['type'] ?? null) === 'image' && $request->hasFile('image')) {
            $path = $request->file('image')->store('content-editor', 'public');
            $value = Storage::disk('public')->url($path);
            $meta['uploaded_path'] = $path;
        }

        abort_if($value === '', 422, 'Немає значення для збереження.');

        $selectorHash = hash('sha256', $data['selector']);

        $override = ContentOverride::query()->updateOrCreate(
            [
                'page_key' => $data['page_key'] ?? 'home',
                'selector_hash' => $selectorHash,
                'type' => $data['type'],
                'original_hash' => $data['original_hash'] ?? null,
            ],
            [
                'selector' => $data['selector'],
                'value' => $value,
                'meta' => $meta ?: null,
                'user_id' => $request->user()?->id,
            ],
        );

        return response()->json([
            'override' => $override->toEditorArray(),
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $data = $request->validate([
            'page_key' => ['nullable', 'string', 'max:80'],
            'selector' => ['required', 'string', 'max:1000'],
            'type' => ['required', Rule::in(['text', 'image'])],
            'original_hash' => ['nullable', 'string', 'max:80'],
        ]);

        $selectorHash = hash('sha256', $data['selector']);

        ContentOverride::query()
            ->forPage($data['page_key'] ?? 'home')
            ->where('selector_hash', $selectorHash)
            ->where('type', $data['type'])
            ->where('original_hash', $data['original_hash'] ?? null)
            ->delete();

        return response()->json(['ok' => true]);
    }
}
