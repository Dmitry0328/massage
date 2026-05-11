<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentOverride extends Model
{
    protected $fillable = [
        'page_key',
        'selector',
        'selector_hash',
        'type',
        'original_hash',
        'value',
        'meta',
        'user_id',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function scopeForPage($query, string $pageKey)
    {
        return $query->where('page_key', $pageKey);
    }

    public function toEditorArray(): array
    {
        return [
            'selector' => $this->selector,
            'type' => $this->type,
            'original_hash' => $this->original_hash,
            'value' => $this->value,
        ];
    }
}
