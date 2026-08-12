<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'client_id', 'client_type', 'establishment_type', 'establishment_size',
        'preferred_date', 'time_slot', 'services', 'cctv_subtype',
        'notes', 'status', 'cancellation_reason', 'assessment_notes',
        'assessment_form_completed_at',
    ];

    protected $casts = [
        'services' => 'array',
        'preferred_date' => 'date',
        'assessment_form_completed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assessors()
    {
        return $this->belongsToMany(Employee::class, 'assessment_assessor');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function items()
    {
        return $this->hasMany(AssessmentItem::class);
    }
}
