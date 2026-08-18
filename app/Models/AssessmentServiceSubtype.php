<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentServiceSubtype extends Model
{
    protected $fillable = ['assessment_service_id', 'name', 'sort_order', 'active'];

    protected $casts = ['active' => 'boolean'];

    public function service()
    {
        return $this->belongsTo(AssessmentService::class, 'assessment_service_id');
    }
}
