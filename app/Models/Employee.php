<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    const POSITION_DRIVER = 'driver';

    const POSITION_TECHNICIAN = 'technician';

    const POSITION_DRIVER_TECHNICIAN = 'driver_technician';

    protected $fillable = [
        'staff_id',
        'position',
    ];

    // ── Relationships ──
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function assessments()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_assessor');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projectTasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    // ── Accessors ──
    public function getFullNameAttribute()
    {
        return $this->staff?->user?->full_name ?? 'Unknown';
    }

    /**
     * driver_technician covers either role; technician/driver only cover their own.
     */
    public function qualifiesForPosition(string $position): bool
    {
        return $this->position === $position || $this->position === self::POSITION_DRIVER_TECHNICIAN;
    }

    /**
     * Every active (non-Completed, non-archived) assignment for this employee —
     * both assessment field-visit Tasks and project ProjectTasks — whose dates
     * overlap the given range. Empty means available.
     */
    public function conflictingAssignments(string $start, string $end, ?int $ignoreProjectTaskId = null): \Illuminate\Support\Collection
    {
        $assessmentConflicts = $this->tasks()
            ->where('is_archived', false)
            ->where('status', '!=', 'Completed')
            ->whereDate('due_date', '<=', $end)
            ->whereDate('due_date', '>=', $start)
            ->with('assessment.client.user')
            ->get()
            ->map(fn ($task) => [
                'type' => 'Assessment',
                'title' => $task->title,
                'context' => $task->assessment?->client?->user?->full_name,
                'start' => $task->due_date->toDateString(),
                'end' => $task->due_date->toDateString(),
                'status' => $task->status,
            ]);

        $projectConflicts = $this->projectTasks()
            ->where('is_archived', false)
            ->where('status', '!=', 'Completed')
            ->when($ignoreProjectTaskId, fn ($q) => $q->where('id', '!=', $ignoreProjectTaskId))
            ->whereDate('start_date', '<=', $end)
            ->whereDate('due_date', '>=', $start)
            ->with('project')
            ->get()
            ->map(fn ($task) => [
                'type' => 'Project',
                'title' => $task->title,
                'context' => $task->project?->project_title,
                'start' => $task->start_date->toDateString(),
                'end' => $task->due_date->toDateString(),
                'status' => $task->status,
            ]);

        return $assessmentConflicts->concat($projectConflicts)->values();
    }
}
