<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTaskChecklistItem extends Model
{
    protected $fillable = ['project_task_id', 'name', 'total_quantity', 'completed_quantity', 'completed_at'];
    protected $casts = ['total_quantity' => 'decimal:2', 'completed_quantity' => 'decimal:2', 'completed_at' => 'datetime'];

    public function projectTask() { return $this->belongsTo(ProjectTask::class); }

    public function progress(): int
    {
        if ((float) $this->total_quantity <= 0) return 0;

        return (int) round(min((float) $this->completed_quantity / (float) $this->total_quantity, 1) * 100);
    }
}
