<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'employee_id',
        'assessment_id',
        'title',
        'description',
        'due_date',
        'status',
        'completed_at',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    // ──────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    // ──────────────────────────────────────────
    // ACCESSORS
    // ──────────────────────────────────────────

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'Completed' => 'success',
            'Pending' => 'warning text-dark',
            'In Progress' => 'primary',
            'Declined' => 'danger',
        ];
        $color = $colors[$this->status] ?? 'secondary';

        return "<span class=\"badge bg-{$color}\">{$this->status}</span>";
    }

    public function getStatusIconAttribute()
    {
        $icons = [
            'Completed' => 'check_circle',
            'Pending' => 'schedule',
            'In Progress' => 'autorenew',
            'Declined' => 'cancel',
        ];

        return $icons[$this->status] ?? 'help';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'Completed' => 'Done',
            'Pending' => 'To Do',
            'In Progress' => 'In Progress',
            'Declined' => 'Declined',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'Completed';
    }

    public function getIsOverdueAttribute()
    {
        return $this->status !== 'Completed' && $this->due_date->isPast();
    }

    public function getDaysUntilDueAttribute()
    {
        return now()->diffInDays($this->due_date, false);
    }
}
