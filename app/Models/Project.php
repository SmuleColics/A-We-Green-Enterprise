<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['quotation_id', 'reference_number', 'project_title', 'service_type', 'location', 'total_budget', 'status', 'start_date', 'end_date', 'completed_at', 'is_archived', 'archived_at'];
    protected $casts = ['total_budget' => 'decimal:2', 'start_date' => 'date', 'end_date' => 'date', 'completed_at' => 'datetime', 'is_archived' => 'boolean', 'archived_at' => 'datetime'];

    public function quotation() { return $this->belongsTo(Quotation::class); }
    public function checklistItems() { return $this->hasMany(ChecklistItem::class); }
    public function tasks() { return $this->hasMany(ProjectTask::class); }
    public function updates() { return $this->hasMany(ProjectUpdate::class)->latest(); }

    public function checklistProgress(): int
    {
        $items = $this->checklistItems;
        if ($items->isEmpty()) return 0;

        $accountedFor = $items->filter(fn ($item) => $item->is_completed || $item->is_not_applicable)->count();

        return (int) round($accountedFor / $items->count() * 100);
    }

    public function returnedItems()
    {
        return $this->checklistItems->filter(fn ($item) => $item->returned_quantity !== null && (float) $item->returned_quantity > 0);
    }

    /**
     * Overall project completion — based on task progress only.
     * The material checklist is tracked separately and never factors in here.
     */
    public function taskProgress(): int
    {
        $tasks = $this->activeTasks();
        if ($tasks->isEmpty()) return 0;

        return (int) round($tasks->avg(fn ($task) => $task->progress()));
    }

    public function activeTasks()
    {
        return $this->tasks->where('is_archived', false);
    }

    public function activeUpdates()
    {
        return $this->updates->where('is_archived', false);
    }

    /**
     * Recompute status from task states after a task changes.
     * 'On Hold' is an admin-only override and is never touched here.
     */
    public function syncStatusFromTasks(): void
    {
        if ($this->status === 'On Hold') return;

        $tasks = $this->activeTasks();

        if ($tasks->isEmpty()) {
            $newStatus = 'Not Started';
        } elseif ($tasks->every(fn ($task) => $task->status === 'Completed')) {
            $newStatus = 'Completed';
        } elseif ($tasks->contains(fn ($task) => $task->status !== 'Pending')) {
            $newStatus = 'In Progress';
        } else {
            $newStatus = 'Not Started';
        }

        if ($newStatus !== $this->status) {
            $this->update([
                'status' => $newStatus,
                'completed_at' => $newStatus === 'Completed' ? ($this->completed_at ?? now()) : null,
            ]);
        }
    }
}
