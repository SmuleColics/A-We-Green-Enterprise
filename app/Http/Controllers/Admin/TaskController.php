<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Assessment;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['employee.staff.user', 'assessment.client.user'])
            ->where('is_archived', false)
            ->orderByDesc('due_date')
            ->get();

        $employees = Employee::with('staff.user')->get();
        $assessments = Assessment::with(['client.user', 'assessors.staff.user'])
            ->where('is_archived', false)
            ->get();

        $total = $tasks->count();
        $pending = $tasks->where('status', 'Pending')->count();
        $inProgress = $tasks->where('status', 'In Progress')->count();
        $completed = $tasks->where('status', 'Completed')->count();
        $declined = $tasks->where('status', 'Declined')->count();

        return view('admin.tasks.tasks', compact(
            'tasks', 'employees', 'assessments', 'total', 'pending', 'inProgress', 'completed', 'declined'
        ));
    }

    public function show(Task $task)
    {
        return response()->json([
            'success' => true,
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'status_icon' => $task->status_icon,
                'status_badge' => $task->status_badge,
                'due_date' => $task->due_date->format('Y-m-d'),
                'days_until_due' => $task->days_until_due,
                'is_overdue' => $task->is_overdue,
                'completed_at' => $task->completed_at?->format('Y-m-d H:i:s'),
                'employee' => [
                    'id' => $task->employee->id,
                    'position' => $task->employee->position,
                    'staff' => [
                        'user' => [
                            'full_name' => $task->employee->staff->user->full_name,
                        ],
                    ],
                ],
                'assessment' => [
                    'id' => $task->assessment->id,
                    'preferred_date' => $task->assessment->preferred_date->format('Y-m-d'),
                    'services' => $task->assessment->services,
                    'client' => [
                        'user' => [
                            'full_name' => $task->assessment->client->user->full_name,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|in:Pending,In Progress,Completed,Declined',
        ]);

        $previousStatus = $task->status;

        if (isset($validated['status'])) {
            if ($validated['status'] === 'Completed' && $previousStatus !== 'Completed') {
                $validated['completed_at'] = now();
            } elseif ($validated['status'] !== 'Completed' && $previousStatus === 'Completed') {
                $validated['completed_at'] = null;
            }
        }

        $task->update($validated);

        $logMessage = "Task #{$task->id} updated.";

        if (isset($validated['status']) && $validated['status'] !== $previousStatus) {
            $logMessage = "Task #{$task->id} status changed from {$previousStatus} to {$validated['status']}.";

            // Guard against a missing employee/staff/user chain before notifying —
            // task.employee_id could point to a deleted or orphaned record.
            $userId = $employee->staff?->user_id;

            if ($userId) {
                NotificationController::notify(
                    module: 'Task',
                    title: 'New Task Assigned',
                    message: "You have been assigned a new task: {$validated['title']}",
                    recipientRole: null,
                    notifiable: $assessment,
                    userId: $userId
                );
            }
        }

        ActivityLogController::log(
            'Task',
            'Updated',
            $logMessage,
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} updated successfully.",
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'assessment_id' => 'required|exists:assessments,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $assessment = Assessment::find($validated['assessment_id']);
        $employee = Employee::find($validated['employee_id']);

        $task = Task::create([
            'employee_id' => $validated['employee_id'],
            'assessment_id' => $validated['assessment_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => 'Pending',
        ]);

        // Notify the employee
        NotificationController::notify(
            module: 'Task',
            title: 'New Task Assigned',
            message: "You have been assigned a new task: {$validated['title']}",
            recipientRole: null,
            notifiable: $assessment,
            userId: $employee->staff->user_id
        );

        ActivityLogController::log(
            'Task',
            'Created',
            "Task #{$task->id} assigned to {$employee->staff->user->full_name} for assessment #{$assessment->id}.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task created and assigned to {$employee->staff->user->full_name}.",
            'task' => $task,
        ]);
    }

    /**
     * Archive a task — soft-hides it from the active list without
     * deleting the row, matching the same is_archived/archived_at
     * pattern already used for Staff and Assessment records.
     */
    public function archive(Task $task)
    {
        $task->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);

        ActivityLogController::log(
            'Task',
            'Archived',
            "Task #{$task->id} ({$task->title}) archived.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} moved to archive.",
        ]);
    }

    /**
     * Restore an archived task back to the active list.
     */
    public function unarchive(Task $task)
    {
        $task->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);

        ActivityLogController::log(
            'Task',
            'Restored',
            "Task #{$task->id} ({$task->title}) restored from archive.",
            auth()->id(),
            auth()->user()->full_name
        );

        return response()->json([
            'success' => true,
            'message' => "Task #{$task->id} restored.",
        ]);
    }

    /**
     * List archived tasks — feeds the "Archived Tasks" modal.
     */
    public function archived()
    {
        $tasks = Task::with(['employee.staff.user'])
            ->where('is_archived', true)
            ->orderByDesc('archived_at')
            ->get()
            ->map(fn ($task) => [
                'id' => $task->id,
                'title' => $task->title,
                'employee_name' => $task->employee->staff->user->full_name ?? 'N/A',
                'status' => $task->status,
                'status_badge' => $task->status_badge,
                'due_date' => $task->due_date->format('M j, Y'),
                'archived_at' => $task->archived_at?->format('M j, Y'),
            ]);

        return response()->json([
            'success' => true,
            'tasks' => $tasks,
        ]);
    }
}
