<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category',
        'unit',
        'unit_cost',
        'selling_price',
        'supplier',
        'location',
        'description',
        'image_path',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'archived_at' => 'datetime',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    /**
     * Markup percentage vs. cost, for internal reference in the
     * View modal (e.g. "42% markup"). Null when selling_price
     * hasn't been set yet, or when unit_cost is 0 (avoid div-by-zero).
     */
    public function getMarkupPercentAttribute(): ?float
    {
        if (! $this->selling_price || ! $this->unit_cost || (float) $this->unit_cost === 0.0) {
            return null;
        }

        return round((($this->selling_price - $this->unit_cost) / $this->unit_cost) * 100, 1);
    }
}
