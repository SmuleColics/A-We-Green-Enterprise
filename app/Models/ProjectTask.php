<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    const POSITION_TECHNICIAN = 'technician';
    const POSITION_DRIVER = 'driver';

    protected $fillable = ['project_id', 'employee_id', 'title', 'description', 'required_position', 'start_date', 'due_date', 'status', 'completed_at', 'is_archived', 'archived_at'];
    protected $casts = ['start_date' => 'date', 'due_date' => 'date', 'completed_at' => 'datetime', 'is_archived' => 'boolean', 'archived_at' => 'datetime'];

    public function project() { return $this->belongsTo(Project::class); }
    public function employee() { return $this->belongsTo(Employee::class); }
    public function checklistItems() { return $this->hasMany(ProjectTaskChecklistItem::class); }

    public function progress(): int
    {
        $items = $this->checklistItems;
        if ($items->isEmpty()) {
            return $this->status === 'Completed' ? 100 : 0;
        }

        return (int) round($items->avg(fn ($item) => $item->progress()));
    }

    public function employeeQualifies(Employee $employee): bool
    {
        return $employee->qualifiesForPosition($this->required_position);
    }

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
}
