<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sight extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'marker_image',
        'marker_pattern',
        'gltf_model',
        'emit_events',
        'smooth',
        'smooth_count',
        'smooth_tolerance',
        'smooth_threshold',
        'position',
        'rotation',
        'scale',
        'is_visible',
    ];

    protected $casts = [
        'emit_events'      => 'boolean',
        'smooth'           => 'boolean',
        'smooth_count'     => 'decimal:2',
        'smooth_tolerance' => 'decimal:2',
        'smooth_threshold' => 'decimal:2',
        'position'         => 'array',
        'rotation'         => 'array',
        'scale'            => 'array',
        'is_visible'       => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
