<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentItem extends Model
{
    protected $fillable = [
        'assessment_id',
        'material_id',
        'item_name',
        'quantity',
        'unit',
        'unit_price',
        'location',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
