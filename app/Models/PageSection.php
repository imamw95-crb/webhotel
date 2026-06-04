<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageSection extends Model
{
    protected $fillable = ['section_key', 'title', 'subtitle', 'content', 'sort_order', 'is_active'];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public static function getSection(string $key): ?self
    {
        return Cache::remember("section_{$key}", 3600, function () use ($key) {
            return static::where('section_key', $key)->where('is_active', true)->first();
        });
    }

    public static function getAllActive(): array
    {
        return Cache::remember('all_sections', 3600, function () {
            return static::active()->ordered()
                ->get()
                ->mapWithKeys(fn ($item) => [$item->section_key => $item])
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('all_sections');
    }
}
