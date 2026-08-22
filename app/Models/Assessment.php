<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $fillable = [
        'client_id', 'booking_group_id', 'client_type', 'establishment_type', 'establishment_size',
        'preferred_date', 'time_slot', 'services', 'cctv_subtype',
        'notes', 'status', 'cancellation_reason', 'assessment_notes',
        'assessment_form_completed_at', 'is_archived', 'archived_at',
    ];

    protected $casts = [
        'services' => 'array',
        'cctv_subtype' => 'array',
        'preferred_date' => 'date',
        'assessment_form_completed_at' => 'datetime',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
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

    public function quotation()
    {
        return $this->hasOne(Quotation::class);
    }

    /**
     * "Done Assessment" once every Task tied to this assessment is
     * Completed. No tasks yet (shouldn't normally happen once assessors
     * are assigned at confirm time) falls back to "Pending".
     */
    public function deriveStatus(): string
    {
        if ($this->assessment_form_completed_at) {
            return 'Submitted Form';
        }

        if ($this->tasks->isEmpty()) {
            return 'Pending';
        }

        return $this->tasks->every(fn ($task) => $task->status === 'Completed')
            ? 'Done Assessment'
            : 'Pending';
    }
}
