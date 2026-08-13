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
        'completed_via_task_id',
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

    public function completedVia(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'completed_via_task_id');
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
            'On Hold' => 'secondary',
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
            'On Hold' => 'pause_circle',
        ];

        return $icons[$this->status] ?? 'help';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'Completed' => 'Done',
            'Pending' => 'To Do',
            'In Progress' => 'In Progress',
            'On Hold' => 'On Hold',
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

    public function getIsAutoCompletedAttribute()
    {
        return ! is_null($this->completed_via_task_id);
    }
}
