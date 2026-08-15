<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\Task;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function checklist(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $projects = Project::with(['quotation.assessment.client.user', 'checklistItems'])
            ->where('is_archived', false)
            ->whereBetween('start_date', [$validated['from'], $validated['to']])
            ->orderBy('start_date')
            ->get()
            ->map(function ($project) {
                $items = $project->checklistItems;
                $total = $items->count();
                $completed = $items->where('is_completed', true)->count();

                return [
                    'checklist' => $project->project_title,
                    'client' => $project->quotation->assessment->client->user->full_name,
                    'service' => $project->service_type,
                    'date' => $project->start_date->format('M j, Y'),
                    'total' => $total,
                    'completed' => $completed,
                    'status' => $project->status,
                    'pct' => $total > 0 ? (int) round($completed / $total * 100) : 0,
                ];
            })
            ->values();

        return response()->json(['success' => true, 'data' => $projects]);
    }

    public function tasks(Request $request)
    {
        $validated = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $statusLabels = [
            'Pending' => 'To Do',
            'In Progress' => 'In Progress',
            'Completed' => 'Done',
            'On Hold' => 'On Hold',
        ];

        $now = now();

        $assessmentTasks = Task::with(['employee.staff.user', 'assessment'])
            ->where('is_archived', false)
            ->whereBetween('due_date', [$validated['from'], $validated['to']])
            ->get()
            ->map(fn ($t) => [
                'task' => $t->title,
                'project' => 'Assessment #' . $t->assessment_id,
                'assignee' => $t->employee->staff->user->full_name ?? 'N/A',
                'priority' => $this->derivePriority($t->due_date, $t->status, $now),
                'start' => $t->due_date->format('M j, Y'),
                'due' => $t->due_date->format('M j, Y'),
                'status' => $statusLabels[$t->status] ?? $t->status,
            ]);

        $projectTasks = ProjectTask::with(['employee.staff.user', 'project'])
            ->where('is_archived', false)
            ->whereBetween('due_date', [$validated['from'], $validated['to']])
            ->get()
            ->map(fn ($t) => [
                'task' => $t->title,
                'project' => $t->project->project_title,
                'assignee' => $t->employee->full_name ?? 'Unassigned',
                'priority' => $this->derivePriority($t->due_date, $t->status, $now),
                'start' => $t->start_date->format('M j, Y'),
                'due' => $t->due_date->format('M j, Y'),
                'status' => $statusLabels[$t->status] ?? $t->status,
            ]);

        $merged = $assessmentTasks->concat($projectTasks)->values();

        return response()->json(['success' => true, 'data' => $merged]);
    }

    private function derivePriority($dueDate, string $status, $now): string
    {
        if ($status === 'Completed') {
            return 'Low';
        }

        if ($dueDate->lt($now->copy()->startOfDay())) {
            return 'High';
        }

        return $now->diffInDays($dueDate, false) <= 3 ? 'Medium' : 'Low';
    }
}
