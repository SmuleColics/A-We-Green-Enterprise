<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'employee_id',
        'assessment_id',
        'title',
        'description',
        'status',
        'due_date',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    // ── Relationships ──
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // ── Status Helpers ──
    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isInProgress(): bool
    {
        return $this->status === 'In Progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function isDeclined(): bool
    {
        return $this->status === 'Declined';
    }

    // ── Accessors ──
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'Pending' => 'bg-warning text-dark',
            'In Progress' => 'bg-info text-white',
            'Completed' => 'bg-success text-white',
            'Declined' => 'bg-danger text-white',
            default => 'bg-secondary text-white',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'Pending' => 'schedule',
            'In Progress' => 'pending_actions',
            'Completed' => 'check_circle',
            'Declined' => 'cancel',
            default => 'help',
        };
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        return $this->due_date?->diffInDays(now(), false);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date < now()->toDateString() && !$this->isCompleted();
    }
}