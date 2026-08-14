<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectTaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $this->validateTask($request);
        $employee = $this->assertAssignable($validated, null);

        $task = DB::transaction(function () use ($project, $validated) {
            $task = $project->tasks()->create([
                'employee_id' => $validated['employee_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'required_position' => $validated['required_position'],
                'start_date' => $validated['start_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'completed_at' => $validated['status'] === 'Completed' ? now() : null,
            ]);

            $this->syncChecklistItems($task, $validated['checklist_items'] ?? []);

            return $task;
        });

        $project->load('tasks.checklistItems');
        $project->syncStatusFromTasks();

        ActivityLogController::log(
            'Project',
            'Created',
            "Task \"{$task->title}\" added to project {$project->reference_number}, assigned to {$employee->full_name}.",
            Auth::id(),
            Auth::user()->full_name
        );

        if ($employee->staff?->user_id) {
            NotificationController::notify(
                module: 'Project',
                title: 'New task assigned',
                message: "You've been assigned \"{$task->title}\" on project {$project->reference_number} ({$task->start_date->format('M j')} - {$task->due_date->format('M j')}).",
                recipientRole: null,
                notifiable: $task,
                userId: $employee->staff->user_id
            );
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', "Task \"{$task->title}\" created.");
    }

    public function update(Request $request, ProjectTask $task)
    {
        $validated = $this->validateTask($request);
        $employee = $this->assertAssignable($validated, $task->id);

        DB::transaction(function () use ($task, $validated) {
            $task->update([
                'employee_id' => $validated['employee_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'required_position' => $validated['required_position'],
                'start_date' => $validated['start_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
                'completed_at' => $validated['status'] === 'Completed' ? ($task->completed_at ?? now()) : null,
            ]);

            $this->syncChecklistItems($task, $validated['checklist_items'] ?? []);
        });

        $project = $task->project;
        $project->load('tasks.checklistItems');
        $project->syncStatusFromTasks();

        ActivityLogController::log(
            'Project',
            'Updated',
            "Task \"{$task->title}\" on project {$project->reference_number} was updated.",
            Auth::id(),
            Auth::user()->full_name
        );

        return redirect()
            ->route('projects.show', $project)
            ->with('success', "Task \"{$task->title}\" updated.");
    }

    public function archive(ProjectTask $task)
    {
        $task->update(['is_archived' => true, 'archived_at' => now()]);

        $project = $task->project;
        $project->load('tasks');
        $project->syncStatusFromTasks();

        ActivityLogController::log(
            'Project',
            'Archived',
            "Task \"{$task->title}\" on project {$project->reference_number} was archived.",
            Auth::id(),
            Auth::user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task \"{$task->title}\" moved to archive.",
        ]);
    }

    private function validateTask(Request $request): array
    {
        return $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'required_position' => 'required|in:technician,driver',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,In Progress,Completed,On Hold',
            'checklist_items' => 'nullable|array',
            'checklist_items.*.id' => 'nullable|integer|exists:project_task_checklist_items,id',
            'checklist_items.*.name' => 'required_with:checklist_items|string|max:255',
            'checklist_items.*.total_quantity' => 'required_with:checklist_items|numeric|min:0.01',
            'checklist_items.*.completed_quantity' => 'nullable|numeric|min:0',
        ]);
    }

    /**
     * Re-checks role + availability server-side — the frontend's live check is a
     * convenience, this is the authority. Hard-rejects on any conflict.
     */
    private function assertAssignable(array $validated, ?int $ignoreTaskId): Employee
    {
        $employee = Employee::findOrFail($validated['employee_id']);

        if (! $employee->qualifiesForPosition($validated['required_position'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'employee_id' => "{$employee->full_name} is a " . str_replace('_', '/', $employee->position) . " and isn't qualified for a {$validated['required_position']} task.",
            ]);
        }

        $conflicts = $employee->conflictingAssignments($validated['start_date'], $validated['due_date'], $ignoreTaskId);
        if ($conflicts->isNotEmpty()) {
            $conflict = $conflicts->first();
            throw \Illuminate\Validation\ValidationException::withMessages([
                'employee_id' => "{$employee->full_name} already has a conflicting assignment: \"{$conflict['title']}\" ({$conflict['start']} to {$conflict['end']}).",
            ]);
        }

        return $employee;
    }

    private function syncChecklistItems(ProjectTask $task, array $items): void
    {
        $keepIds = [];

        foreach ($items as $item) {
            $total = (float) $item['total_quantity'];
            $completed = min((float) ($item['completed_quantity'] ?? 0), $total);
            $data = [
                'name' => $item['name'],
                'total_quantity' => $total,
                'completed_quantity' => $completed,
                'completed_at' => $completed >= $total ? now() : null,
            ];

            if (! empty($item['id']) && ($existing = $task->checklistItems()->find($item['id']))) {
                $existing->update($data);
                $keepIds[] = $existing->id;
            } else {
                $keepIds[] = $task->checklistItems()->create($data)->id;
            }
        }

        $task->checklistItems()->whereNotIn('id', $keepIds)->delete();
    }
}
