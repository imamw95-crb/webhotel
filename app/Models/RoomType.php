<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'base_price',
        'max_occupancy', 'max_adults', 'max_children',
        'room_size', 'bed_configuration',
        'image_path', 'gallery', 'facilities',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'gallery' => 'array',
        'facilities' => 'array',
        'base_price' => 'decimal:2',
        'max_occupancy' => 'integer',
        'max_adults' => 'integer',
        'max_children' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
