<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentItem extends Model
{
    protected $fillable = [
        'assessment_id',
        'item_name',
        'quantity',
        'unit',
        'location',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
